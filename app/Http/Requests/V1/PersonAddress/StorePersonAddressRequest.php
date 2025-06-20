<?php

namespace App\Http\Requests\V1\PersonAddress;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cep' => 'required|string|min:1|max:255',
            'cidade' => 'required|string|min:1|max:255',
            'logradouro' => 'required|string|min:1|max:255',
            'bairro' => 'sometimes|string|min:0|max:255',
            'estado' => 'required|string|min:1|max:255',
            'complemento' => 'required|string|min:1|max:255',
            'bloco' => 'required|string|min:1|max:255',
            'numero' => 'required|string|min:1|max:255',
            'tipo' => 'sometimes|in:casa,apartamento',
            'importancia' => 'sometimes|in:principal,secundario',
            'active' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
        ];
    }
}
