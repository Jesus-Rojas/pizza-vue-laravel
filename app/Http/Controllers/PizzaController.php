<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPizzaRequest;
use App\Http\Requests\EditPizzaRequest;
use App\Models\Ingrediente;
use App\Models\IngredientePizza;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PizzaController extends Controller
{
    public function index()
    {
        return response()->json(Pizza::with('ingrediente_pizzas.ingredientes')->paginate(10));
    }

    public function ventaPizza()
    {
        return response()
            ->json(
                Pizza::where('stock', '>', 0)
                ->with('ingrediente_pizzas.ingredientes')
                ->paginate(10)
            );
    }


    public function create()
    {
        //
    }

    public function store(AddPizzaRequest $request)
    {
        try {
            // pendiente validar los textos a array
            $ingredientes = json_decode($request['ingredientes']);
            $imagen = $request->file('imagen')->store('public/pizzas');
            $imagen = Storage::url($imagen);
            $pizza = Pizza::create([
                'nombre' => $request['nombre'],
                'precio' => $request['precio'],
                'stock' => $request['stock'],
                'imagen' => $imagen,
            ]);
            foreach ($ingredientes as $value) {
                $ingrediente = Ingrediente::where('id', $value)->first();
                if ($ingrediente) {
                    IngredientePizza::create([
                        'ingredientes_id' => $value, 
                        'pizzas_id' => $pizza->id, 
                    ]);
                }
            }
            return response()->json([
                'status' => 'ok',
                'message' => 'La pizza se creo con exito',
            ]);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function show(Pizza $pizza)
    {
        //
    }

    public function edit(Pizza $pizza)
    {
        //
    }

    public function update(EditPizzaRequest $request, $id)
    {
        try {
            // pendiente validar los textos a array
            
            $pizza = Pizza::where('id', $id)->first();
            if (!$pizza) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ], 404);
            }
            
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen')->store('public/pizzas');
                $imagen = Storage::url($imagen);
                $pizza->update([
                    'imagen' => $imagen
                ]);
            }
            
            $pizza->update([
                'nombre' => $request['nombre'],
                'precio' => $request['precio'],
                'stock' => $request['stock'],
            ]);

            $ingredientesNew = json_decode($request['ingredientes']);
            $ingredientesOld = IngredientePizza::where('pizzas_id', $id)->pluck('ingredientes_id');
            $ingredientesOld = json_decode(json_encode($ingredientesOld));
            $diferencia = array_diff($ingredientesOld,$ingredientesNew);
            foreach ($diferencia as $value) {
                $ingrediente = Ingrediente::where('id', $value)->first();
                if ($ingrediente) {
                    $ingrediente = IngredientePizza::where([
                        ['pizzas_id', $pizza->id],
                        ['ingredientes_id', $value]
                    ])
                    ->first();
                    if ($ingrediente) {
                        $ingrediente->delete();
                    }
                }
            }
            foreach ($ingredientesNew as $value) {
                $ingrediente = Ingrediente::where('id', $value)->first();
                if ($ingrediente) {
                    $ingrediente = IngredientePizza::where([
                        ['pizzas_id', $pizza->id],
                        ['ingredientes_id', $value]
                    ])
                    ->first();
                    if (!$ingrediente) {
                        IngredientePizza::create([
                            'ingredientes_id' => $value, 
                            'pizzas_id' => $pizza->id, 
                        ]);
                    }
                }
            }
            return response()->json([
                'mensaje' => 'Registro se actualizo con exito',
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pizza = Pizza::find($id);
            if (!$pizza) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ], 404);
            }
            $pizza->delete();
            return response()->json([
                'mensaje' => 'Registro se elimino con exito',
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
