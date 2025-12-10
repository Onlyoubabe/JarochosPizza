<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-8">Carrito de Compras</h1>

        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($cart as $item)
                        <li class="px-4 py-4 sm:px-6 flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img class="h-16 w-16 rounded-md object-cover" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                                    <p class="text-lg font-bold text-gray-900">${{ number_format($item['price'], 2) }}</p>
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    <p>Ingredientes: {{ implode(', ', array_column($item['ingredients'], 'name')) }}</p>
                                </div>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('cart.remove', $item['id']) }}" class="text-red-600 hover:text-red-900 text-sm font-medium">Eliminar</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="px-4 py-4 sm:px-6 bg-gray-50 flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('checkout.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Proceder al Pago
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Tu carrito está vacío.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="text-red-600 hover:text-red-500 font-medium">Continuar Comprando <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        @endif
    </div>
</x-store-layout>
