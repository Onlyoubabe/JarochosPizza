<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        // Validate request (payment info, etc.)
        // For now, assuming PayPal returns a transaction ID or we just simulate it.
        
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id() ?? 1, // Fallback to user 1 if guest (or require login)
            'total_price' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'paypal',
            'payment_status' => 'paid', // Simulating successful payment
            'transaction_id' => $request->transaction_id ?? 'SIMULATED_TRANS_ID',
        ]);

        foreach ($cart as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'pizza_id' => $item['pizza_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Attach ingredients
            // We stored ingredients as array of ['id' => ..., 'name' => ...]
            $ingredientIds = array_column($item['ingredients'], 'id');
            $orderItem->ingredients()->attach($ingredientIds);
        }

        Session::forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with(['items.pizza', 'items.ingredients'])->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
