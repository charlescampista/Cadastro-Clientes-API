<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // cria 5 usuários de teste (senha = password)
        User::factory()->count(5)->create();

        // cria um usuário admin conhecido para login rápido:
        User::create([
            'name' => 'Admin Local',
            'email' => 'admin@local.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'token' => null,
            'create_token' => null,
        ]);
    }
}