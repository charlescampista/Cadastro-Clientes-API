<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// grupo de rotas protegidas por por autenticação.
Route::middleware('token.auth')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
});
