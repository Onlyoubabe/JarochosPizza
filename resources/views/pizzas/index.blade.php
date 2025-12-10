<x-store-layout>
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Pizza Premium</span>
                            <span class="block text-red-600 xl:inline">entregada a ti</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Experimenta el sabor de la auténtica pizza italiana, elaborada con los mejores ingredientes. Personaliza la tuya o elige entre nuestras especialidades del chef.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#menu" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10">
                                    Ordenar Ahora
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Pizza">
        </div>
    </div>

    <div id="menu" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-8">Nuestro Menú</h2>
        
        <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:gap-x-8">
            @foreach($pizzas as $pizza)
                <div class="group relative bg-white border border-gray-200 rounded-lg flex flex-col overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="aspect-w-3 aspect-h-2 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-56">
                        <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="w-full h-full object-center object-cover sm:w-full sm:h-full">
                    </div>
                    <div class="flex-1 p-4 space-y-2 flex flex-col">
                        <h3 class="text-xl font-medium text-gray-900">
                            <a href="{{ route('pizzas.show', $pizza) }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $pizza->name }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500">{{ $pizza->description }}</p>
                        <div class="flex-1 flex flex-col justify-end">
                            <p class="text-lg font-bold text-gray-900">${{ $pizza->price }}</p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <a href="{{ route('pizzas.show', $pizza) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            Personalizar y Añadir
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-store-layout>
