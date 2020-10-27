<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class PessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        if(Auth::check()){
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
            'name'          =>'required',
            'documento'     =>'required',
            'celular_1'     =>'required',
            'cep'           =>'required',
            'logradouro'    =>'required',
            'bairro'        =>'required',
            'cidade'        =>'required',
            'estado'        =>'required|max:2|min:2',

        ];





    }

    public function messages()
    {
        return [
            'name.required'         =>'Informe o nome da pessoa',
            'documento.required'    =>'Informe o cpf / cnpj',
            'celular_1.required'    =>'Informe um número para contato',
            'cep.required'          =>'Informe o cep',
            'logradouro.required'   =>'Informe o logradouro',
            'bairro.required'       =>'Informe o bairro',
            'cidade.required'       =>'Informe o cidade',
            'estado.required'       =>'Informe o estado',
            'estado.max'            =>'Informe a sigla do estado com dois caracteres',
            'estado.min'            =>'Informe a sigla do estado com dois caracteres',

        ];
    }
}




