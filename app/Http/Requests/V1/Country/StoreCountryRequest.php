<?php

namespace App\Http\Requests\V1\Country;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'nmPais' => 'required|string|min:1|max:255',
            'cdPais' => 'required|string|min:1|max:255',
            'padrao' => 'required||in:yes,no',
            'active' => 'sometimes|in:yes,no'
        ];
    }
}
