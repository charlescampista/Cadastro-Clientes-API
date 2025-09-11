<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // autenticação via middleware
    }

    public function rules()
    {
        $userId = $this->route('id'); // para ignorar email do próprio usuário na validação

        return [
            'name' => 'sometimes|required|string|max:191',
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6'
        ];
    }
}
