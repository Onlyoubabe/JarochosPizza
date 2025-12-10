<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.pizza', 'items.ingredients'])->latest()->get();
        $pizzas = Pizza::all();
        $ingredients = Ingredient::all();
        
        return view('admin.dashboard', compact('orders', 'pizzas', 'ingredients'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }
}
