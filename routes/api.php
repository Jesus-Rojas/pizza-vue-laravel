<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PizzaController;
use Illuminate\Support\Facades\Route;

Route::get('problems', function () {
    return response()->json('El token es invalido o no tienes permiso para ingresar a esta ruta', 401);
})->name('problems');

Route::get('pizza/ventaPizza', [PizzaController::class, 'ventaPizza']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);

Route::resource('pedido', PedidoController::class);

Route::group([ 'middleware' => ['api', 'admin'], ], function ($router) {
    Route::get('ingrediente/all', [IngredienteController::class, 'all']);
    // Route::post('sendEmail', [MailController::class, 'sendEmail']);
    Route::resource('ingrediente', IngredienteController::class);
    Route::resource('pizza', PizzaController::class);
});