<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="pizzaBuilder({{ $pizza->price }}, {{ $pizza->ingredients->pluck('id') }}, {{ $allIngredients->flatten()->map(fn($i) => ['id' => $i->id, 'price' => $i->price]) }})">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            <!-- Image Gallery -->
            <div class="flex flex-col-reverse">
                <div class="w-full aspect-w-1 aspect-h-1">
                    <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="w-full h-full object-center object-cover sm:rounded-lg">
                </div>
            </div>

            <!-- Pizza Info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $pizza->name }}</h1>
                <div class="mt-3">
                    <h2 class="sr-only">Información del producto</h2>
                    <p class="text-3xl text-gray-900" x-text="'$' + totalPrice.toFixed(2)"></p>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Descripción</h3>
                    <div class="text-base text-gray-700 space-y-6">
                        <p>{{ $pizza->description }}</p>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                    
                    <div class="mt-10">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Personalizar Ingredientes</h3>
                        </div>

                        @foreach($allIngredients as $category => $ingredients)
                            <div class="mt-4 border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-medium text-gray-900 capitalize">{{ $category }}</h4>
                                <div class="mt-2 grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                                    @foreach($ingredients as $ingredient)
                                        <div class="relative flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="ingredient-{{ $ingredient->id }}" name="ingredients[]" value="{{ $ingredient->id }}" type="checkbox" 
                                                    x-model="selectedIngredients"
                                                    class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="ingredient-{{ $ingredient->id }}" class="font-medium text-gray-700">{{ $ingredient->name }}</label>
                                                <span class="text-gray-500 ml-1">(+${{ $ingredient->price }})</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex sm:flex-col1">
                        <button type="submit" class="max-w-xs flex-1 bg-red-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-red-500 sm:w-full">
                            Añadir al Carrito
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function pizzaBuilder(basePrice, defaultIngredients, allIngredientsData) {
            return {
                basePrice: basePrice,
                selectedIngredients: defaultIngredients, // Array of IDs
                allIngredients: allIngredientsData, // Array of {id, price}
                
                get totalPrice() {
                    let currentTotal = this.basePrice;
                    const getPrice = (id) => {
                        const ing = this.allIngredients.find(i => i.id === id);
                        return ing ? parseFloat(ing.price) : 0;
                    };
                    
                    this.selectedIngredients.forEach(id => {
                        if (!defaultIngredients.includes(id)) {
                            currentTotal += getPrice(id);
                        }
                    });
                    
                    return currentTotal;
                }
            }
        }
    </script>
</x-store-layout>
