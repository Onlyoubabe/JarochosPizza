<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function create()
    {
        $pizzas = Pizza::all();
        $ingredients = \App\Models\Ingredient::all();
        $users = User::where('role', 'customer')->orderBy('name')->get();
        return view('admin.orders.create', compact('pizzas', 'users', 'ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'guest_name' => 'required_without:user_id|nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.pizza_id' => 'required|exists:pizzas,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $pizza = Pizza::find($item['pizza_id']);
                $basePrice = $pizza->price;
                $extrasPrice = 0;
                
                // Calculate price of extras
                if (isset($item['ingredients']) && is_array($item['ingredients'])) {
                    $extras = \App\Models\Ingredient::whereIn('id', $item['ingredients'])->get();
                    foreach ($extras as $extra) {
                        $extrasPrice += $extra->price;
                    }
                }

                $unitPrice = $basePrice + $extrasPrice;
                $rowTotal = $unitPrice * $item['quantity'];
                $total += $rowTotal;

                $itemsData[] = [
                    'pizza_id' => $pizza->id,
                    'quantity' => $item['quantity'],
                    'price' => $unitPrice,
                    'ingredients' => $item['ingredients'] ?? [], // Store IDs to attach later
                ];
            }

            $order = Order::create([
                'user_id' => $request->user_id, // Can be null
                'guest_name' => $request->user_id ? null : $request->guest_name,
                'total_price' => $total,
                'status' => 'pending', 
                'payment_method' => 'cash',
                'payment_status' => 'pending', 
                'transaction_id' => 'POS-' . strtoupper(uniqid()),
            ]);
            
            foreach ($itemsData as $data) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'pizza_id' => $data['pizza_id'],
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                ]);

                if (!empty($data['ingredients'])) {
                    $orderItem->ingredients()->attach($data['ingredients']);
                }
            }

            DB::commit();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pedido creado exitosamente.', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al crear el pedido: ' . $e->getMessage()], 500);
        }
    }

    public function ticket(Order $order)
    {
        $order->load(['items.pizza', 'items.ingredients', 'user']);
        return view('admin.orders.ticket', compact('order'));
    }
}
