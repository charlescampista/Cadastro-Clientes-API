<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // autenticação via middleware
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:191',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
        ];
    }
}
