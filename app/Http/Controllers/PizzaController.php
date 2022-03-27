<?php

namespace App\Http\Controllers;

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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'imagen' => 'required',
                'stock' => 'required',
                'precio' => 'required',
                'ingredientes' => 'required',
            ]);
            if (!$request->hasFile('imagen')) {
                return response()->json([
                    'status' => 'bad',
                    'message' => 'Es obligatoria la imagen',
                ]);
            }
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
                IngredientePizza::create([
                    'ingredientes_id' => $value, 
                    'pizzas_id' => $pizza->id, 
                ]);
            }
            return response()->json([
                'status' => 'ok',
                'message' => 'La pizza se creo con exito',
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
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

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombre' => 'required',
                'stock' => 'required',
                'precio' => 'required',
                'ingredientes' => 'required',
            ]);
            $pizza = Pizza::find($id);
            if (!$pizza) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ]);
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
                $ingrediente = IngredientePizza::where([
                    ['pizzas_id', $id],
                    ['ingredientes_id', $value]
                ])
                ->first();
                if ($ingrediente) {
                    $ingrediente->delete();
                }
            }
            foreach ($ingredientesNew as $value) {
                $ingrediente = IngredientePizza::where([
                    ['pizzas_id', $id],
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
            return response()->json([
                'mensaje' => 'Registro se actualizo con exito',
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
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
                ]);
            }
            $pizza->delete();
            return response()->json([
                'mensaje' => 'Registro se elimino con exito',
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
