<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pizza</title>
</head>
<body>
  <h1> {{ $details['title'] }} </h1>
  <table border="1">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($details['body']['detalle_pedidos'] as $value)
      <tr>
        <td>{{ $value['pizzas']['nombre'] }}</td>
        <td>{{ $value['precio_unitario'] }}</td>
        <td>{{ $value['cantidad'] }}</td>
        <td>{{ $value['precio_unitario'] * $value['cantidad'] }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <br>
  <p>Total Venta: {{ $details['body']['venta_total'] }}</p>
</body>
</html>