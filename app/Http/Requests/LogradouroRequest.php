<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class LogradouroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cep.required'          => 'Informe o cep',
            'cep.max'               => 'O cep deve ter no máximo 9 caracteres',
            'cep.min'               => 'O cep deve ter no mínimo 9 caracteres',
            'logradouro.required'   => 'Informe o logradouro',
            'logradouro.max'        => 'O logradouro deve ter no máximo 255 caracteres',
            'logradouro.min'        => 'O logradouro deve ter no mínimo 3 caracteres',
            'bairro.required'       => 'Informe o bairro',
            'bairro.max'            => 'O bairro deve ter no máximo 255 caracteres',
            'bairro.min'            => 'O bairro deve ter no mínimo 3 caracteres',
            'cidade.required'       => 'Informe o cidade',
            'cidade.max'            => 'O nome da cidade deve ter no máximo 255 caracteres',
            'cidade.min'            => 'O nome da cidade deve ter no mínimo 3 caracteres',
            'estado.required'       => 'Informe o estado',
            'estado.max'            => 'Informe a sigla do estado com 2 caracteres',
            'estado.min'            => 'Informe a sigla do estado com 2 caracteres',
        ];
    }

    public function messages()
    {
        return [

            'cep.required'          => 'Informe o cep',
            'cep.max'               => 'O cep deve ter no máximo 9 caracteres',
            'cep.min'               => 'O cep deve ter no mínimo 9 caracteres',
            'logradouro.required'   => 'Informe o logradouro',
            'logradouro.max'        => 'O logradouro deve ter no máximo 255 caracteres',
            'logradouro.min'        => 'O logradouro deve ter no mínimo 3 caracteres',
            'bairro.required'       => 'Informe o bairro',
            'bairro.max'            => 'O bairro deve ter no máximo 255 caracteres',
            'bairro.min'            => 'O bairro deve ter no mínimo 3 caracteres',
            'cidade.required'       => 'Informe o cidade',
            'cidade.max'            => 'O nome da cidade deve ter no máximo 255 caracteres',
            'cidade.min'            => 'O nome da cidade deve ter no mínimo 3 caracteres',
            'estado.required'       => 'Informe o estado',
            'estado.max'            => 'Informe a sigla do estado com 2 caracteres',
            'estado.min'            => 'Informe a sigla do estado com 2 caracteres',

        ];
    }
}
