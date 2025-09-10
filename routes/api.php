<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// grupo de rotas protegidas por por autenticação.
Route::middleware('token.auth')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::delete('clients/{id}', [ClientController::class, 'destroy']);
});
