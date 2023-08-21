<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//controladores
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ContratacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('catalogos', CatalogosController::class);
Route::resource('personal', PersonalController::class);
Route::resource('contratacion', ContratacionController::class);
Route::resource('movimiento', MovimientoController::class);
