<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\EmpleadoController;
use App\Http\Controllers\Api\UsoPuertaController;

Route::post('uso_puerta', [UsoPuertaController::class, 'store']);

Route::post('empleado/login', [EmpleadoController::class, 'login']);

Route::post('filter', [UsoPuertaController::class, 'filterPost']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

