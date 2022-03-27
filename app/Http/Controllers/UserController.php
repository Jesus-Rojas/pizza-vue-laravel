<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::paginate(10));
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);
        $user = User::where([
            'password' => $request['password'],
            'email' => $request['email'],
        ])
        ->first();
        if (!$user) {
            return response()->json([
                'status' => 'bad',
                'mensaje' => 'Las credenciales no son validas, intenta de nuevo',
            ]);
        }
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Login success',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required',
            'name' => 'required',
        ]);
        $user = User::create([
            'email' => $request['email'],
        ])
        ->first();
        if ($user) {
            return response()->json([
                'status' => 'bad',
                'mensaje' => 'El usuario ya se encuentra registrado en el sistema',
            ]);
        }
        $user = User::create([
            'password' => $request['password'],
            'email' => $request['email'],
            'name' => $request['name'],
        ]);
        if (!$user) {
            return response()->json([
                'status' => 'bad',
                'mensaje' => 'Error en el servidor',
            ]);
        }
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Se creo usuario con exito',
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
