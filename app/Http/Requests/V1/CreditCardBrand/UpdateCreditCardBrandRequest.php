<?php

namespace App\Http\Requests\V1\CreditCardBrand;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditCardBrandRequest extends FormRequest
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
            'name' => 'required|min:1|max:255',
            'standard' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
            'pessoa_autor_id' => 'sometimes|exists:App\Pessoa,id',
        ];
    }
}
