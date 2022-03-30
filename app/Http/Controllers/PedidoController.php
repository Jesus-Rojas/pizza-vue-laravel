<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
use App\Jobs\SendEmail;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Pizza;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(PedidoRequest $request)
    {
        try {
            DB::beginTransaction();
            // temporal user
            $user = auth()->user();
            $pedido = Pedido::create([
                'venta_total' => $request['venta_total'],
                'users_id' => $user->id,
            ]);
            foreach ($request['pedido'] as $value) {
                // pendiente restar stock
                $pizza = Pizza::where('id', $value['pizzas_id'])->first();
                if ($pizza) {
                    if ($value['cantidad'] > $pizza->stock ) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'verificar',
                            'mensaje' => 'Algunos productos no tienen stock',
                            'pizza' => [
                                'id' => $pizza->id,
                                'cantidad' => $pizza->stock,
                            ]
                        ], 422);
                    } else {
                        $pizza->update([
                            'stock' => $pizza->stock - $value['cantidad']
                        ]);
                    }
                    DetallePedido::create([
                        'cantidad' => $value['cantidad'],
                        'precio_unitario' => $value['precio_unitario'],
                        'pizzas_id' => $value['pizzas_id'],
                        'pedidos_id' => $pedido->id,
                    ]);
                }
            }
            DB::commit();
            // consulto de nuevo para traer todas sus relaciones, me facilito trabajo en el blade
            $pedido = Pedido::where('id', $pedido->id)->with('detalle_pedidos.pizzas')->first();
            $details = [
                'title' => 'Gracias por su compra',
                'body' => $pedido,
                'destinatario' => $user->email,
                'asunto' => 'Pizza - Comprobante de pago',
            ];
            SendEmail::dispatch($details);
            return response()->json([
                'status' => 'success',
                'mensaje' => 'El pedido se creo con exito',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th, 500);
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
