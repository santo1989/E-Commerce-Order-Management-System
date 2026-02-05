<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Invoice #{{ $order->id }}</h1>
        <p>Status: {{ $order->status }}</p>
    </div>

    <h3>Items</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: {{ $order->total }}</h3>
</body>

</html>
