<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\PartidaUserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('juegos', JuegoController::class)->except(['destroy', 'store']);
Route::apiResource('users', UserController::class)->except(['destroy']);
Route::apiResource('partidas', PartidaController::class)->except(['destroy']);
//Route::apiResource('aciertos', PartidaUserController::class);
Route::prefix('aciertos')->group(function () {
    Route::get('/', [PartidaUserController::class, 'index']);
    Route::post('/', [PartidaUserController::class, 'store']);
    Route::get('/{id}', [PartidaUserController::class, 'show']);
    Route::put('/{id}', [PartidaUserController::class, 'update']);
    Route::delete('/{id}', [PartidaUserController::class, 'destroy']);
    Route::get('/partida/{partida_id}', [PartidaUserController::class, 'porPartida']);
    Route::get('/usuario/{user_id}', [PartidaUserController::class, 'porUsuario']);
    Route::get('/usuario/{user_id}/partida/{partida_id}', [PartidaUserController::class, 'porUsuarioYPartida']);
});
