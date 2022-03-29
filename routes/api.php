<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('register', [UserController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    
    Route::resource('pizza', PizzaController::class);
    Route::get('ingrediente/all', [IngredienteController::class, 'all']);
    Route::resource('ingrediente', IngredienteController::class);
    Route::resource('pedido', PedidoController::class);
    Route::resource('rol', RolController::class);
    Route::resource('user', UserController::class);

});

// Route::post('sendEmail', [MailController::class, 'sendEmail']);

Route::get('ventaPizza', [PizzaController::class, 'ventaPizza']);

