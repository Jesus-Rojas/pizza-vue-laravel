<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredienteRequest;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index()
    {
        return response()->json(Ingrediente::paginate(10));
    }

    public function all()
    {
        return response()->json(Ingrediente::all());
    }

    public function create()
    {
        //
    }

    public function store(IngredienteRequest $request)
    {
        try {
            Ingrediente::create([
                'nombre' => $request['nombre']
            ]);
            return response()->json([
                'mensaje' => 'Se creo registro con exito',
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th, 404);
        }
    }

    public function show(Ingrediente $ingrediente)
    {
        //
    }

    public function edit(Ingrediente $ingrediente)
    {
        //
    }

    public function update(IngredienteRequest $request, $id)
    {
        try {
            $ingrediente = Ingrediente::find($id);
            if (!$ingrediente) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ], 404);
            }
            $ingrediente->update([
                'nombre' => $request['nombre']
            ]);
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
            $ingrediente = Ingrediente::find($id);
            if (!$ingrediente) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ], 404);
            }
            $ingrediente->delete();
            return response()->json([
                'mensaje' => 'Registro se elimino con exito',
                'status' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
