<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $order->id }}</title>
    <style>
        @media print {
            @page { margin: 0; size: 80mm auto; }
            body { margin: 0.5cm; }
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0 auto;
            background: white;
            color: black;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .upper { text-transform: uppercase; }
        .line { border-bottom: 1px dashed black; margin: 5px 0; }
        .my-2 { margin-top: 10px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .qty { width: 10%; }
        .desc { width: 65%; }
        .price { width: 25%; }
        .small { font-size: 10px; }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center">
        <h2 class="my-2 upper">Jarochos Pizza</h2>
        <p>Ticket de Venta</p>
        <div class="line"></div>
        <p>
            Folio: #{{ $order->id }}<br>
            Fecha: {{ $order->created_at->format('d/m/Y H:i') }}<br>
            Cajero: {{ auth()->user()->name }}
        </p>
        @if($order->guest_name)
            <p>Cliente: {{ $order->guest_name }} (Mostrador)</p>
        @elseif($order->user)
            <p>Cliente: {{ $order->user->name }}</p>
        @endif
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr class="upper font-bold small">
                <td class="qty">Cant</td>
                <td class="desc">Desc</td>
                <td class="price text-right">Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        {{ $item->pizza->name }}
                        @if($item->ingredients->count() > 0)
                            <div class="small">
                                + {{ $item->ingredients->pluck('name')->implode(', ') }}
                            </div>
                        @endif
                    </td>
                    <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <table class="font-bold">
        <tr>
            <td class="text-right">TOTAL:</td>
            <td class="text-right price">${{ number_format($order->total_price, 2) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center my-2">
        <p>¡Gracias por su compra!<br>Vuelva pronto</p>
        <p class="small">www.jarochospizza.com</p>
    </div>

</body>
</html>
