<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// grupo de rotas protegidas por por autenticação.
Route::middleware('token.auth')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'index']);
    Route::get('users/{id}', [AuthController::class, 'show']);
    Route::put('users/{id}', [AuthController::class, 'update']);
    Route::delete('users/{id}', [AuthController::class, 'destroy']);

    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::get('clients/{id}', [ClientController::class, 'show']);
    Route::put('clients/{id}', [ClientController::class, 'update']);
    Route::delete('clients/{id}', [ClientController::class, 'destroy']);

});
