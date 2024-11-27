<?php

namespace App\Http\Requests\V1\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'nmCidade' => 'required|max:255|min:2',
            'cdCidade' => 'required|max:100',
            'sigla' => 'max:100|min:2',
            'estado_id' => 'required|min:1'
        ];
    }
}
