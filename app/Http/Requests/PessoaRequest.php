<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
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
            'name'          => 'required|max:255|min:3',
            'documento'     => 'required|max:14',
            'celular_1'     => 'required',
            'cep'           => 'required|max:9|min:9',
            'logradouro'    => 'required|max:255|min:3',
            'bairro'        => 'required|max:255|min:3',
            'cidade'        => 'required|max:255|min:3',
            'estado'        => 'required|max:2|min:2',

        ];





    }

    public function messages()
    {
        return [
            'name.required'         => 'Informe o nome da pessoa',
            'name.max'              => 'O nome da pessoa deve ter no máximo 255 caracteres',
            'name.min'              => 'O nome da pessoa deve ter no mínimo 3 caracteres',
            'documento.required'    => 'Informe o cpf',
            'documento.max'         => 'O cpf deve ter no máximo 14 caracteres',
            'celular_1.required'    => 'Informe um número para contato',
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
