<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $pizza = Pizza::findOrFail($request->pizza_id);
        $ingredients = Ingredient::whereIn('id', $request->ingredients ?? [])->get();
        
        // Calculate price based on base pizza + extra ingredients
        // For simplicity, we'll just add ingredient prices to base price
        // Or if the pizza is "custom", we sum all ingredients.
        // Let's assume base price covers standard ingredients, and we add extra cost for added ones?
        // The user said "choose ingredients, remove".
        // Let's calculate price as: Base Price + (Sum of ALL selected ingredients prices) - (Sum of DEFAULT ingredients prices)?
        // Or simpler: Base Price is for the default configuration.
        // If user adds/removes, we adjust.
        // Let's go with: Price = Base Price + Sum(Added Ingredients) - Sum(Removed Ingredients)?
        // No, simpler: Price = Base Price + Sum(Selected Ingredients Price) - Sum(Default Ingredients Price).
        // Actually, easiest is: Price = Base Price + Sum(Extra Ingredients). Removing ingredients doesn't reduce price usually in pizzerias, but adding does.
        // Let's stick to: Price = Base Price + Sum of *Extra* ingredients.
        
        // But wait, if I build a custom pizza?
        // Let's just calculate total price of selected ingredients if it's a custom pizza.
        // For now, let's just take the price passed from frontend or calculate it here.
        // Calculating here is safer.
        
        $basePrice = $pizza->price;
        $selectedIngredientsPrice = $ingredients->sum('price');
        
        // We need to know which ingredients are "extra".
        // For this MVP, let's just say Price = Base Price + Sum(All Selected Ingredients).
        // Wait, that would double count if base price includes them.
        // Let's assume Base Price includes the default ingredients.
        // So we need to find the difference.
        
        // Let's just trust the price calculation for now or keep it simple:
        // Final Price = Base Price + (Sum of ALL selected ingredients prices).
        // This means the Base Price in DB should be the "dough + labor" cost, and ingredients are added on top?
        // Or Base Price is the full price, and we only add cost for *additional* ingredients.
        
        // Let's go with: Price = Base Price. 
        // If we add ingredients that were NOT in the default, we add their price.
        
        $defaultIngredientIds = $pizza->ingredients->pluck('id')->toArray();
        $selectedIngredientIds = $ingredients->pluck('id')->toArray();
        
        $extraIngredients = array_diff($selectedIngredientIds, $defaultIngredientIds);
        $extraCost = Ingredient::whereIn('id', $extraIngredients)->sum('price');
        
        $finalPrice = $basePrice + $extraCost;

        $cart = Session::get('cart', []);
        $cartItem = [
            'id' => uniqid(), // Unique ID for cart item (since same pizza can have diff ingredients)
            'pizza_id' => $pizza->id,
            'name' => $pizza->name,
            'price' => $finalPrice,
            'quantity' => 1,
            'ingredients' => $ingredients->map(fn($i) => ['id' => $i->id, 'name' => $i->name])->toArray(),
            'image_url' => $pizza->image_url
        ];
        
        $cart[] = $cartItem;
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Pizza added to cart!');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        $cart = array_filter($cart, fn($item) => $item['id'] !== $id);
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }
}
