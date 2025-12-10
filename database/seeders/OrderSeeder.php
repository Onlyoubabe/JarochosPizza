<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Pizza;
use App\Models\Ingredient;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'customer')->get();
        $pizzas = Pizza::all();
        $ingredients = Ingredient::all();

        if ($users->isEmpty() || $pizzas->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Create 3-5 orders per user
            for ($i = 0; $i < rand(3, 5); $i++) {
                $status = ['pending', 'preparing', 'ready', 'delivered'][rand(0, 3)];
                
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => 0, // Will calculate below
                    'status' => $status,
                    'payment_method' => 'paypal',
                    'payment_status' => 'paid',
                    'transaction_id' => 'SIM-' . uniqid(),
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);

                $total = 0;
                // Add 1-3 items per order
                for ($j = 0; $j < rand(1, 3); $j++) {
                    $pizza = $pizzas->random();
                    $quantity = rand(1, 2);
                    $price = $pizza->price;

                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'pizza_id' => $pizza->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);
                    
                    // Randomly add extra ingredients
                    if (rand(0, 1)) {
                        $extraIngredients = $ingredients->random(rand(1, 2));
                        $orderItem->ingredients()->attach($extraIngredients->pluck('id'));
                        foreach ($extraIngredients as $ing) {
                            $price += $ing->price;
                        }
                    }

                    $total += $price * $quantity;
                }

                $order->update(['total_price' => $total]);
            }
        }
    }
}
