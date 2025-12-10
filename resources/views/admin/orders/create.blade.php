<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Pedido en Tienda (POS)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="posApp()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column: Menu -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">Menú</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($pizzas as $pizza)
                                <div class="border rounded-lg p-4 cursor-pointer hover:shadow-md transition" @click="openModal({{ $pizza }})">
                                    <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="h-32 w-full object-cover rounded-md mb-2">
                                    <h4 class="font-bold">{{ $pizza->name }}</h4>
                                    <p class="text-sm text-gray-600 truncate">{{ $pizza->description }}</p>
                                    <div class="mt-2 text-red-600 font-bold">${{ number_format($pizza->price, 2) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-medium mb-4">Resumen del Pedido</h3>
                        
                        <!-- Customer Type Switcher -->
                        <div class="flex border-b mb-4">
                            <button class="flex-1 py-2 text-sm font-medium" 
                                    :class="customerType === 'registered' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-700'"
                                    @click="customerType = 'registered'; guestName = '';">
                                Registrado
                            </button>
                            <button class="flex-1 py-2 text-sm font-medium" 
                                    :class="customerType === 'guest' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-500 hover:text-gray-700'"
                                    @click="customerType = 'guest'; userId = '';">
                                Mostrador / Nuevo
                            </button>
                        </div>
                        
                        <!-- Customer Selection (Registered) -->
                        <div class="mb-4" x-show="customerType === 'registered'">
                            <label class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select x-model="userId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Seleccionar Cliente</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Guest Name Input (Walk-in) -->
                        <div class="mb-4" x-show="customerType === 'guest'">
                            <label class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                            <input type="text" x-model="guestName" placeholder="Ej. Juan Pérez" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        <!-- Cart Items -->
                        <div class="space-y-4 mb-4 max-h-96 overflow-y-auto">
                            <template x-if="cart.length === 0">
                                <p class="text-gray-500 text-sm text-center py-4">No hay artículos en el pedido.</p>
                            </template>
                            <template x-for="(item, index) in cart" :key="index">
                                <div class="flex flex-col border-b pb-2">
                                    <div class="flex justify-between items-center">
                                        <div class="flex-1">
                                            <div class="font-medium" x-text="item.name"></div>
                                            <div class="text-xs text-gray-500" x-text="'Base: $' + item.basePrice.toFixed(2)"></div>
                                            <template x-if="item.ingredients.length > 0">
                                                <div class="text-xs text-indigo-600 mt-1">
                                                    Extras: <span x-text="item.ingredients.map(i => i.name).join(', ')"></span>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button @click="decreaseQty(index)" class="px-2 py-1 bg-gray-200 rounded text-gray-600">-</button>
                                            <span x-text="item.quantity"></span>
                                            <button @click="increaseQty(index)" class="px-2 py-1 bg-gray-200 rounded text-gray-600">+</button>
                                        </div>
                                        <div class="ml-4 font-bold" x-text="'$' + (item.totalPrice * item.quantity).toFixed(2)"></div>
                                        <button @click="removeFromCart(index)" class="ml-2 text-red-500">&times;</button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Total -->
                        <div class="border-t pt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span x-text="'$' + total.toFixed(2)"></span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button @click="submitOrder" 
                                    :disabled="cart.length === 0 || (!userId && !guestName) || loading"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                <span x-show="!loading">Crear Pedido</span>
                                <span x-show="loading">Procesando...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customization Modal -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="closeModal">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="selectedPizza.name"></h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    Personaliza tu pizza agregando ingredientes extra.
                                </div>

                                <div class="mt-4 max-h-60 overflow-y-auto">
                                    <h4 class="font-bold text-sm mb-2">Ingredientes Extra:</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($ingredients as $ingredient)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" value="{{ $ingredient->id }}" class="form-checkbox h-5 w-5 text-red-600" 
                                                    @change="toggleIngredient({{ $ingredient }})">
                                                <span class="ml-2 text-sm">{{ $ingredient->name }} (+$<span x-text="{{ $ingredient->price }}"></span>)</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="confirmAddToCart" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Añadir (+$<span x-text="currentPizzaTotal.toFixed(2)"></span>)
                        </button>
                        <button type="button" @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function posApp() {
            return {
                cart: [],
                userId: '',
                guestName: '',
                customerType: 'guest',
                loading: false,
                isModalOpen: false,
                selectedPizza: {},
                selectedIngredients: [],
                
                // Helper for the modal total
                get currentPizzaTotal() {
                    let total = parseFloat(this.selectedPizza.price || 0);
                    this.selectedIngredients.forEach(ing => {
                        total += parseFloat(ing.price);
                    });
                    return total;
                },

                get total() {
                    return this.cart.reduce((sum, item) => sum + (item.totalPrice * item.quantity), 0);
                },

                openModal(pizza) {
                    this.selectedPizza = pizza;
                    this.selectedIngredients = [];
                    // Reset checkboxes
                    document.querySelectorAll('input[type="checkbox"]').forEach(el => el.checked = false);
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.selectedPizza = {};
                    this.selectedIngredients = [];
                },

                toggleIngredient(ingredient) {
                    const index = this.selectedIngredients.findIndex(i => i.id === ingredient.id);
                    if (index > -1) {
                        this.selectedIngredients.splice(index, 1);
                    } else {
                        this.selectedIngredients.push(ingredient);
                    }
                },

                confirmAddToCart() {
                    // Generate a simplified ID for grouping same pizzas with same ingredients
                    // This implementation treats every addition as unique for simplicity, 
                    // allowing customization of each individual pizza.
                    
                    this.cart.push({
                        id: this.selectedPizza.id,
                        name: this.selectedPizza.name,
                        basePrice: parseFloat(this.selectedPizza.price),
                        totalPrice: this.currentPizzaTotal,
                        quantity: 1,
                        ingredients: [...this.selectedIngredients] // Copy array
                    });
                    
                    this.closeModal();
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                increaseQty(index) {
                    this.cart[index].quantity++;
                },

                decreaseQty(index) {
                    if (this.cart[index].quantity > 1) {
                        this.cart[index].quantity--;
                    } else {
                        this.removeFromCart(index);
                    }
                },

                async submitOrder() {
                    if (this.customerType === 'registered' && !this.userId) {
                        alert('Por favor selecciona un cliente.');
                        return;
                    }
                    if (this.customerType === 'guest' && !this.guestName) {
                        alert('Por favor ingresa el nombre del cliente.');
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch("{{ route('admin.orders.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                user_id: this.userId || null,
                                guest_name: this.guestName || null,
                                items: this.cart.map(item => ({
                                    pizza_id: item.id,
                                    quantity: item.quantity,
                                    ingredients: item.ingredients.map(i => i.id) // Send ingredient IDs
                                }))
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            if (confirm('Pedido creado exitosamente. ¿Desea imprimir el ticket?')) {
                                let ticketUrl = "{{ route('admin.orders.ticket', ':id') }}".replace(':id', data.order_id);
                                window.open(ticketUrl, '_blank', 'width=400,height=600');
                            }
                            
                            this.cart = [];
                            this.userId = '';
                            this.guestName = '';
                            
                            // Optional: Delay redirect to allow print window to open
                            setTimeout(() => {
                                window.location.href = "{{ route('admin.dashboard') }}";
                            }, 500);
                        } else {
                            alert('Error: ' + data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Ocurrió un error al procesar el pedido.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
