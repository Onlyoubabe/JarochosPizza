<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Pedidos Activos</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pedido</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artículos</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($order->user)
                                                {{ $order->user->name }}
                                            @else
                                                <span class="text-indigo-600 font-bold" title="Cliente de Mostrador">{{ $order->guest_name }} (Mostrador)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <ul class="list-disc pl-4">
                                                @foreach($order->items as $item)
                                                    <li>
                                                        {{ $item->quantity }}x {{ $item->pizza->name }}
                                                        @if($item->ingredients->count() > 0)
                                                            <div class="text-xs text-indigo-600 font-semibold ml-2">
                                                                + {{ $item->ingredients->pluck('name')->join(', ') }}
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ $order->total_price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 
                                                @elseif($order->status == 'preparing') bg-blue-100 text-blue-800 
                                                @elseif($order->status == 'ready') bg-green-100 text-green-800 
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ match($order->status) {
                                                    'pending' => 'Pendiente',
                                                    'preparing' => 'Preparando',
                                                    'ready' => 'Listo',
                                                    'delivered' => 'Entregado',
                                                    default => ucfirst($order->status)
                                                } }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="pending" @if($order->status == 'pending') selected @endif>Pendiente</option>
                                                    <option value="preparing" @if($order->status == 'preparing') selected @endif>Preparando</option>
                                                    <option value="ready" @if($order->status == 'ready') selected @endif>Listo</option>
                                                    <option value="delivered" @if($order->status == 'delivered') selected @endif>Entregado</option>
                                                </select>
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">Actualizar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
