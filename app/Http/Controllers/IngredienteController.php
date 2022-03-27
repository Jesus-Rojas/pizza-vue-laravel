<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    public function index()
    {
        return response()->json(Ingrediente::paginate(10));
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
            ]);
            // return response()->json($request->all());
            $ingrediente = Ingrediente::create([
                'nombre' => $request['nombre']
            ]);
    
            if ($ingrediente->save()) {
                return response()->json([
                    'mensaje' => 'Se creo registro con exito',
                    'status' => 'ok'
                ]);
            }
    
            return response()->json([
                'mensaje' => 'problemas en el servidor verificar',
                'status' => 'bad'
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
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

    public function update(Request $request, $id)
    {
        try {
            $ingrediente = Ingrediente::find($id);
            if (!$ingrediente) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ]);
            }
            $ingrediente->update([
                'nombre' => $request['nombre']
            ]);
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
            $ingrediente = Ingrediente::find($id);
            if (!$ingrediente) {
                return response()->json([
                    'mensaje' => 'El registro no existe',
                    'status' => 'bad'
                ]);
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
