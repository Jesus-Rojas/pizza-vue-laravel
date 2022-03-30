<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Exception;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $rol = auth()->user()->roles_id;
            if ($rol == 1) {
                return $next($request);
            }
            return response()->json(['error' => 'Unautorized'], 419);
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid'], 419);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired'], 419);
            }else{
                return response()->json(['status' => 'Authorization Token not found'], 419);
            }
        }
        
    }
}
