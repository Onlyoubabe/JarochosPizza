<x-store-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-8">Finalizar Compra</h1>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <div>
                <h2 class="text-lg font-medium text-gray-900">Resumen del Pedido</h2>
                <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($cart as $item)
                            <li class="flex py-6 px-4 sm:px-6">
                                <div class="flex-shrink-0">
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 rounded-md object-center object-cover">
                                </div>
                                <div class="ml-6 flex-1 flex flex-col">
                                    <div class="flex">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm">
                                                <a href="#" class="font-medium text-gray-700 hover:text-gray-800">{{ $item['name'] }}</a>
                                            </h4>
                                            <p class="mt-1 text-sm text-gray-500">{{ implode(', ', array_column($item['ingredients'], 'name')) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex-1 pt-2 flex items-end justify-between">
                                        <p class="mt-1 text-sm font-medium text-gray-900">${{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <dl class="border-t border-gray-200 py-6 px-4 sm:px-6 space-y-6">
                        <div class="flex items-center justify-between">
                            <dt class="text-base font-medium">Total</dt>
                            <dd class="text-base font-medium text-gray-900">${{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-10 lg:mt-0">
                <h2 class="text-lg font-medium text-gray-900">Método de Pago</h2>
                
                <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <!-- PayPal Button Container -->
                    <div id="paypal-button-container"></div>
                    
                    <!-- Fallback Form for testing without PayPal keys -->
                    <form action="{{ route('orders.store') }}" method="POST" id="manual-checkout-form" class="hidden">
                        @csrf
                        <input type="hidden" name="payment_method" value="paypal">
                        <input type="hidden" name="transaction_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PayPal SDK Stub -->
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $total }}'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Call your server to save the transaction
                    // For now, we just submit the form with the transaction ID
                    const form = document.getElementById('manual-checkout-form');
                    form.querySelector('input[name="transaction_id"]').value = details.id;
                    form.submit();
                });
            }
        }).render('#paypal-button-container');
    </script>
</x-store-layout>
