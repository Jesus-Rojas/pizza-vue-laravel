<?php

namespace App\Http\Controllers;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        return response()->json(Pedido::with('detalle_pedidos.pizzas','users')->paginate(10));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'pedido' => 'required',
                'venta_total' => 'required',
            ]);
            // temporal user
            $user = User::where('email', $request['token'])->first();
            $pedido = Pedido::create([
                'venta_total' => $request['venta_total'],
                'users_id' => $user->id,
            ]);
            foreach ($request['pedido'] as $value) {
                // pendiente restar stock
                DetallePedido::create([
                    'cantidad' => $value['cantidad'],
                    'precio_unitario' => $value['precio_unitario'],
                    'pizzas_id' => $value['pizzas_id'],
                    'pedidos_id' => $pedido->id,
                ]);
            }
            return response()->json([
                'status' => 'ok',
                'mensaje' => 'El pedido se creo con exito',
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function show(Pedido $pedido)
    {
        //
    }

    public function edit(Pedido $pedido)
    {
        //
    }

    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    public function destroy(Pedido $pedido)
    {
        //
    }
}
