<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <!-- Welcome Hero Section -->
    <div class="relative overflow-hidden" style="background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 L100 0 L100 100 Z" fill="white" />
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl drop-shadow-md">
                            <span class="block">¡Hola, {{ Auth::user()->name }}!</span>
                            <span class="block text-red-100 text-3xl mt-2 font-medium">¿Listo para otra rebanada?</span>
                        </h1>
                        <p class="mt-3 text-base text-white sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 shadow-black/10">
                            Bienvenido a tu espacio personal. Revisa tus pedidos activos, consulta tu historial o pide tu favorita de nuevo en segundos.
                        </p>
                        @if(!$activeOrder)
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow-lg">
                                <a href="{{ route('home') }}#menu" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 hover:shadow-xl transition-all">
                                    <span class="mr-2">🍕</span> Ordenar Pizza
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-90" src="https://images.unsplash.com/photo-1590947132387-155cc02f3212?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Pizza Dashboard">
            <div class="absolute inset-0 bg-gradient-to-r from-red-700 via-transparent to-transparent lg:via-red-700/50"></div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Active Order Status -->
            @if($activeOrder)
                <div class="bg-white overflow-hidden shadow-2xl rounded-2xl border-t-8 border-red-600 transform transition-all hover:-translate-y-1">
                    <div class="p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Pedido en Curso <span class="text-red-600">#{{ $activeOrder->id }}</span></h3>
                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Realizado el {{ $activeOrder->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-red-100 rounded-full shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                                Ver Detalles &rarr;
                            </a>
                        </div>
                        
                        <!-- Premium Progress Bar -->
                        <div class="relative pt-4">
                             <div class="w-full overflow-hidden h-6 mb-4 text-xs rounded-full bg-gray-100 shadow-inner border border-gray-200">
                                <div style="width: {{ $activeOrder->status == 'pending' ? '25%' : ($activeOrder->status == 'preparing' ? '50%' : ($activeOrder->status == 'ready' ? '75%' : '100%')) }};
                                            background-color: {{ $activeOrder->status == 'pending' ? '#eab308' : ($activeOrder->status == 'preparing' ? '#3b82f6' : ($activeOrder->status == 'ready' ? '#6366f1' : '#22c55e')) }};"
                                     class="h-full shadow-lg text-center whitespace-nowrap text-white justify-center transition-all duration-1000 ease-out relative overflow-hidden flex items-center
                                     {{ $activeOrder->status != 'delivered' ? 'animate-pulse' : '' }}">
                                     <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30"></div>
                                     <span class="w-full font-bold drop-shadow-md text-[10px] sm:text-xs">
                                         {{ $activeOrder->status == 'pending' ? 'CONFIRMADO' : ($activeOrder->status == 'preparing' ? 'HORNEANDO' : ($activeOrder->status == 'ready' ? 'LISTO' : 'ENTREGADO')) }}
                                     </span>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs sm:text-sm font-medium text-gray-500 mt-2 px-1">
                                <span class="{{ $activeOrder->status == 'pending' ? 'text-yellow-600 font-bold' : '' }} flex flex-col items-center">
                                    <span class="text-xl mb-1">📋</span> Recibido
                                </span>
                                <span class="{{ $activeOrder->status == 'preparing' ? 'text-blue-600 font-bold' : '' }} flex flex-col items-center">
                                    <span class="text-xl mb-1">👨‍🍳</span> Preparando
                                </span>
                                <span class="{{ $activeOrder->status == 'ready' ? 'text-indigo-600 font-bold' : '' }} flex flex-col items-center">
                                    <span class="text-xl mb-1">🍕</span> Listo
                                </span>
                                <span class="{{ $activeOrder->status == 'delivered' ? 'text-green-600 font-bold' : '' }} flex flex-col items-center">
                                    <span class="text-xl mb-1">🛵</span> Entregado
                                </span>
                            </div>
                            
                            <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100 flex items-start">
                                <span class="text-2xl mr-3">💡</span>
                                <p class="text-blue-900 font-medium text-sm sm:text-base">
                                    @if($activeOrder->status == 'pending')
                                        Tu pedido ha sido confirmado. ¡En breve comenzaremos a prepararlo!
                                    @elseif($activeOrder->status == 'preparing')
                                        El horno está a toda potencia. Nuestros chefs están creando tu obra maestra.
                                    @elseif($activeOrder->status == 'ready')
                                        ¡Ding! Tu pizza está lista y huele delicioso.
                                    @else
                                        ¡Esperamos que disfrutes tu pizza! Gracias por confiar en nosotros.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Stats & Recent -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Recent Orders Card -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <span class="bg-red-100 text-red-600 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                Historial Reciente
                            </h3>
                            <a href="{{ route('orders.index') }}" class="text-red-600 hover:text-red-800 text-sm font-bold hover:underline">Ver todo</a>
                        </div>
                        
                        @if($recentOrders->isEmpty())
                            <div class="text-center py-12 text-gray-400 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                <p>No tienes pedidos anteriores.</p>
                            </div>
                        @else
                            <ul class="space-y-4">
                                @foreach($recentOrders as $order)
                                    <li class="group flex items-center p-4 hover:bg-red-50 rounded-xl transition-all duration-200 cursor-pointer border border-gray-100 hover:border-red-200 shadow-sm hover:shadow-md">
                                        <div class="flex-shrink-0 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold overflow-hidden shadow-sm" style="width: 4rem; height: 4rem; min-width: 4rem;">
                                            @if($order->items->first() && $order->items->first()->pizza->image_url)
                                                <img src="{{ $order->items->first()->pizza->image_url }}" class="w-full h-full object-cover" style="object-fit: cover;">
                                            @else
                                                🍕
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <p class="text-sm font-bold text-gray-900 group-hover:text-red-700">
                                                {{ $order->items->first()->pizza->name }}
                                                @if($order->items->count() > 1) <span class="font-normal text-gray-500 text-xs">+{{ $order->items->count() - 1 }} extra</span> @endif
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-black text-gray-900">${{ number_format($order->total_price, 2) }}</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold 
                                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Promo / CTA Card -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-2xl overflow-hidden relative text-white transform hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/dark-matter.png')]"></div>
                    <!-- Decorative Circle -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-600 rounded-full blur-3xl opacity-20"></div>
                    
                    <div class="p-8 relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-2xl font-bold">Favoritos del Chef</h3>
                                <span class="text-2xl">👨‍🍳</span>
                            </div>
                            <p class="text-gray-300 mb-6 font-light">Descubre nuestras especialidades exclusivas de temporada, curadas para los paladares más exigentes.</p>
                        </div>
                        <div class="space-y-4 bg-white/5 p-4 rounded-lg backdrop-blur-sm border border-white/10">
                            @foreach($featuredPizzas as $pizza)
                                <div class="flex items-center space-x-3">
                                    <span class="{{ $loop->even ? 'bg-green-600' : 'bg-red-600' }} text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm tracking-wider uppercase">
                                        {{ $loop->even ? 'CLÁSICO' : 'FAVORITO' }}
                                    </span>
                                    <span class="font-medium text-sm">{{ $pizza->name }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-6">
                            <a href="{{ route('home') }}#menu" class="block w-full text-center bg-white text-gray-900 font-bold py-3 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all shadow-lg hover:shadow-xl group">
                                Explorar Menú Completo <span class="inline-block transition-transform group-hover:translate-x-1 ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
