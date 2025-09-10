<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Listar clientes
    public function index(Request $request)
    {
        try {
            $clients = Client::orderBy('id', 'desc')->get();

            return response()->json([
                'data' => $clients,
                'count' => $clients->count()
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao buscar clientes', 'error' => $e->getMessage()], 500);
        }
    }

    // Criar cliente
    public function store(StoreClientRequest $request)
    {
        try {
            $data = $request->validated();
            $client = Client::create($data);

            return response()->json([
                'message' => 'Cliente criado com sucesso',
                'client' => $client
            ], 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao criar cliente', 'error' => $e->getMessage()], 500);
        }
    }

    // Delete cliente
    public function destroy($id)
    {
        try {
            $client = Client::find($id);

            if (!$client) {
                return response()->json(['message' => 'Cliente não encontrado'], 404);
            }

            $client->delete();

            return response()->json(['message' => 'Cliente excluído com sucesso'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Erro ao excluir cliente', 'error' => $e->getMessage()], 500);
        }
    }
}
