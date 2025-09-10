<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $bearer = $request->bearerToken();

            if (!$bearer) {
                return response()->json(['message' => 'Token não informado'], 401);
            }

            $user = User::where('token', $bearer)->first();

            if (!$user) {
                return response()->json(['message' => 'Token inválido'], 401);
            }

            // create_token é convertido para o fomato de data dentro do model do usuário
            if (!$user->create_token || $user->create_token->addHours(2)->isPast()) {
                return response()->json(['message' => 'Token expirado'], 401);
            }

            // define o usuário autenticado no runtime
            Auth::setUser($user);

            return $next($request);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao validar token', 'error' => $e->getMessage()], 500);
        }
    }
}
