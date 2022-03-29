<?php

namespace App\Http\Controllers;

use App\Http\Requests\PizzaRequest;
use App\Models\Ingrediente;
use App\Models\IngredientePizza;
use App\Models\Pizza;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function validar($stock, $precio, $ingredientes)
    {
        // Validacion manual debido al formData
        if(!is_numeric($stock)) {
            return ['error' => 'El campo stock deber ser numerico'];
        }
        if(!is_numeric($precio)) {
            return ['error' => 'El campo precio deber ser numerico'];
        }
        if(!is_array($ingredientes)) {
            return ['error' => 'El campo ingredientes deber ser un array'];
        }
        foreach ($ingredientes as $value) {
            if (!is_numeric($value)) {
                return ['error' => 'El campo array debe contener numeros'];
            }
        }
        return ['success' => 'Paso validaciones'];
    }

    public function store(PizzaRequest $request)
    {
        try {
            $ingredientes =  json_decode($request['ingredientes']);
            $repuesta = $this->validar($request['stock'],$request['precio'],$ingredientes);
            if (array_key_exists('error', $repuesta)) {
                return response()->json($repuesta, 422);
            }
            $datos = [
                'ingredientes' => $ingredientes,
                'nombre' => $request['nombre'],
                'stock' => json_decode($request['stock']),
                'precio' => json_decode($request['precio']),
            ];

            $imagen = $request->file('imagen')->store('public/pizzas');
            $imagen = Storage::url($imagen);
            $pizza = Pizza::create([
                'nombre' => $datos['nombre'],
                'precio' => $datos['precio'],
                'stock' => $datos['stock'],
                'imagen' => $imagen,
            ]);
            foreach ($datos['ingredientes'] as $value) {
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

    public function update(PizzaRequest $request, $id)
    {
        try {
            // pendiente validar los textos a array
            $ingredientes =  json_decode($request['ingredientes']);
            $repuesta = $this->validar($request['stock'],$request['precio'],$ingredientes);
            if (array_key_exists('error', $repuesta)) {
                return response()->json($repuesta, 422);
            }
            $datos = [
                'ingredientes' => $ingredientes,
                'nombre' => $request['nombre'],
                'stock' => json_decode($request['stock']),
                'precio' => json_decode($request['precio']),
            ];
            
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
                'nombre' => $datos['nombre'],
                'precio' => $datos['precio'],
                'stock' => $datos['stock'],
            ]);

            $ingredientesNew = $datos['ingredientes'];
            $ingredientesOld = IngredientePizza::where('pizzas_id', $id)->pluck('ingredientes_id');
            $ingredientesOld = json_decode(json_encode($ingredientesOld));
            $diferencia = array_diff($ingredientesOld, $ingredientesNew);
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
