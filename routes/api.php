<?php

use App\Http\Controllers\Api\LineaController;
use App\Http\Controllers\Api\PuntoController;
use App\Http\Controllers\Api\RecorridoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ---------- API FOR FLUTTER ------------ //

// LINEA
Route::get('linea', [LineaController::class, 'index'])->name('linea');

// RUTA
Route::get('punto', [PuntoController::class, 'index'])->name('punto');
Route::get('ruta', [PuntoController::class, 'ruta'])->name('ruta');
Route::get('transbordo', [PuntoController::class, 'transbordo'])->name('transbordo');

// RECORRIDO
Route::get('recorrido', [RecorridoController::class, 'index'])->name('recorrido');
