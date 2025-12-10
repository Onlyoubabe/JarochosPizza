<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Menú (Pizzas)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.pizzas.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    + Nueva Pizza
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pizzas as $pizza)
                            <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden hover:shadow-lg transition-shadow duration-300 h-full">
                                <div class="aspect-w-3 aspect-h-2 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-56">
                                    <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="w-full h-full object-center object-cover sm:w-full sm:h-full">
                                </div>
                                <div class="flex-1 p-4 space-y-2 flex flex-col">
                                    <h3 class="text-xl font-medium text-gray-900">
                                        {{ $pizza->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-3">{{ $pizza->description }}</p>
                                    <div class="flex-1 flex flex-col justify-end mt-2">
                                        <p class="text-lg font-bold text-gray-900">${{ number_format($pizza->price, 2) }}</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-gray-50 border-t border-gray-100 flex gap-3">
                                    <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="flex-1 flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.pizzas.destroy', $pizza) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro de eliminar esta pizza?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-gray-50">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
