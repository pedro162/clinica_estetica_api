<?php

namespace App\Http\Requests\V1\Person;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:255',
            'name_opcional' => 'sometimes|string|min:0|max:255',
            'documento' => 'required|string|min:11|max:14',
            'documento_complementar' => 'sometimes|string|min:0|max:255',
            'email' => 'sometimes|string|email|max:255',
            'nascimento_fundacao' => 'sometimes|date_format:Y-m-d|before_or_equal:' . now()->format('Y-m-d'),
            'sexo' => 'sometimes|in:m,f',
            'tipo' => 'sometimes|in:fisica,juridica',
            'active' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
        ];
    }
}
