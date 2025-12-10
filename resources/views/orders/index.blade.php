<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Pedidos') }}
        </h2>
    </x-slot>

    <!-- Header Section -->
    <div class="relative bg-gray-900 text-white overflow-hidden shadow-lg">
        <div class="absolute inset-0 bg-red-800 opacity-50"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10 text-center">
            <h1 class="text-3xl font-extrabold sm:text-4xl drop-shadow-md">Historial de Compras</h1>
            <p class="mt-4 text-lg text-red-100 max-w-2xl mx-auto">Consulta el estado de tus entregas y revive tus momentos favoritos.</p>
        </div>
    </div>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                @forelse ($orders as $order)
                    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 transition-shadow hover:shadow-xl">
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    Pedido <span class="text-red-600">#{{ $order->id }}</span>
                                </h3>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">
                                    {{ $order->created_at->format('d M Y') }} &bull; {{ $order->created_at->format('h:i A') }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-xl font-black text-gray-900">${{ number_format($order->total_price, 2) }}</span>
                                <div class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 
                                       ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ match($order->status) {
                                        'pending' => 'Pendiente',
                                        'preparing' => 'Preparando',
                                        'ready' => 'Listo',
                                        'delivered' => 'Entregado',
                                        'cancelled' => 'Cancelado',
                                        default => ucfirst($order->status)
                                    } }}
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar (Only for active orders) -->
                        @if(in_array($order->status, ['pending', 'preparing', 'ready']))
                        <div class="px-6 pt-6">
                            <div class="w-full overflow-hidden h-3 mb-2 text-xs rounded-full bg-gray-200">
                                <div style="width: {{ $order->status == 'pending' ? '25%' : ($order->status == 'preparing' ? '50%' : ($order->status == 'ready' ? '75%' : '100%')) }};
                                            background-color: {{ $order->status == 'pending' ? '#eab308' : ($order->status == 'preparing' ? '#3b82f6' : ($order->status == 'ready' ? '#6366f1' : '#22c55e')) }};"
                                     class="h-full shadow-none text-center whitespace-nowrap text-white justify-center transition-all duration-1000 ease-out animate-pulse">
                                </div>
                            </div>
                            <div class="flex justify-between text-xs font-semibold text-gray-500">
                                <span class="{{ $order->status == 'pending' ? 'text-yellow-600' : '' }}">Pendiente</span>
                                <span class="{{ $order->status == 'preparing' ? 'text-blue-600' : '' }}">Preparando</span>
                                <span class="{{ $order->status == 'ready' ? 'text-indigo-600' : '' }}">Listo</span>
                                <span class="{{ $order->status == 'delivered' ? 'text-green-600' : '' }}">Entregado</span>
                            </div>
                        </div>
                        @endif

                        <!-- Order Items -->
                        <div class="p-6">
                            <ul class="divide-y divide-gray-100">
                                @foreach ($order->items as $item)
                                    <li class="py-4 flex items-start">
                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                            @if($item->pizza && $item->pizza->image_url)
                                                <img src="{{ $item->pizza->image_url }}" alt="{{ $item->pizza->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-full text-gray-400">
                                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-bold text-gray-900">{{ $item->pizza->name }}</h4>
                                                <p class="text-sm font-medium text-gray-600">x{{ $item->quantity }}</p>
                                            </div>
                                            <!-- Extras -->
                                            @if($item->ingredients->count() > 0)
                                                <div class="mt-1 flex flex-wrap gap-1">
                                                    @foreach($item->ingredients as $ingredient)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700">
                                                            + {{ $ingredient->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                           <span class="text-sm font-semibold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-white shadow-lg rounded-xl">
                        <div class="mx-auto h-24 w-24 text-gray-300">
                             <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Aún no has hecho pedidos</h3>
                        <p class="mt-1 text-sm text-gray-500">¿Qué esperas para probar la mejor pizza?</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Ver Menú
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
