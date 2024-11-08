<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
</head>
<body>
    <h1>Factura #{{ $factura->idFactura }}</h1>
    <p>Fecha: {{ $factura->fechaFactura }}</p>
    <p>Total: ${{ $factura->totalFactura }}</p>

    <h2>Detalles</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->nombreProducto }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>Q{{ $detalle->precioUnitario }}</td>
                <td>Q{{ $detalle->precioFinal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
