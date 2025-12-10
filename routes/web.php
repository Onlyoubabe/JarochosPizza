<?php

use App\Http\Controllers\PizzaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PizzaController::class, 'index'])->name('home');
Route::get('/pizzas/{pizza}', [PizzaController::class, 'show'])->name('pizzas.show');
Route::view('/about', 'about')->name('about');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Fallback for GET logout
    Route::get('/logout', function () {
        Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin() || $user->isEmployee()) {
            return redirect()->route('admin.dashboard');
        }
        
        $activeOrder = \App\Models\Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->latest()
            ->first();
            
        $recentOrders = \App\Models\Order::where('user_id', $user->id)
            ->with(['items.pizza'])
            ->latest()
            ->take(3)
            ->get();

        $featuredPizzas = \App\Models\Pizza::inRandomOrder()->take(3)->get();

        return view('dashboard', compact('activeOrder', 'recentOrders', 'featuredPizzas'));
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin,employee'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/ticket', [App\Http\Controllers\AdminOrderController::class, 'ticket'])->name('orders.ticket');
    
    Route::resource('pizzas', App\Http\Controllers\AdminPizzaController::class);
    
    Route::get('/orders/create', [App\Http\Controllers\AdminOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\AdminOrderController::class, 'store'])->name('orders.store');

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminUserController::class, 'store'])->name('users.store');
    });
});

require __DIR__.'/auth.php';
