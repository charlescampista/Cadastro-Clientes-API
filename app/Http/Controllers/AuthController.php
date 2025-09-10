<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Cria um novo usuário
    public function register(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'token' => null,
                'create_token' => null,
            ]);

            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ], 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao criar usuário', 'error' => $e->getMessage()], 500);
        }
    }

    // Realiza login, gera token e salva token + create_token
    public function login(LoginRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            $token = Str::random(80);
            $user->token = $token;
            $user->create_token = Carbon::now();
            $user->save();

            return response()->json([
                'message' => 'Autenticado com sucesso',
                'token' => $token,
                'expires_at' => $user->create_token->addHours(2)->toDateTimeString()
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao autenticar', 'error' => $e->getMessage()], 500);
        }
    }

    // Realiza o Logout e invalida o token
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Usuário não encontrado ou não autenticado'], 401);
            }

            $user->token = null;
            $user->create_token = null;
            $user->save();

            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao realizar logout', 'error' => $e->getMessage()], 500);
        }
    }
}
