<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Pizza') }}: {{ $pizza->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.pizzas.update', $pizza) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Pizza:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $pizza->name) }}" required 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                            <textarea name="description" id="description" rows="3" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $pizza->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Precio ($):</label>
                                <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $pizza->price) }}" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('price') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Actualizar Imagen (Opcional):</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @if($pizza->image_url)
                                    <p class="text-xs text-gray-500 mt-1">Actual: <a href="{{ $pizza->image_url }}" target="_blank" class="text-blue-500 hover:underline">Ver Imagen</a></p>
                                @endif
                                @error('image') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.pizzas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Actualizar Pizza
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
