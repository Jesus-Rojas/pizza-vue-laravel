<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login','register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = User::where('email', $request['email'])->first();
            if ($user) {
                return response()->json([
                    'error' => 'El usuario ya se encuentra registrado en el sistema',
                ], 403);
            }
            $user = User::create([
                'password' => Hash::make($request['password']),
                'email' => $request['email'],
                'name' => $request['name'],
                'roles_id' => 2,
            ]);
            $credentials = request(['email', 'password']);
            $token = auth()->attempt($credentials);
            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
