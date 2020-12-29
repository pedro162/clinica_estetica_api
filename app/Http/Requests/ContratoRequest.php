<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class ContratoRequest extends FormRequest
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
            'filial_id'=>'required|numeric|min:1',
            'vrAdesao' => 'numeric|min:0',
            'vrContrato' => 'required|numeric|min:001',
            'dtVencimento'=> 'required|date',
            'isLiberaCatraca'=>'required',
        ];
    }


    public function messages()
    {
        return [
            'filial_id.required'            =>'Filial inválida',
            'filial_id.numeric'             =>'Código de filial inválido',
            'filial_id.min'                 =>'Código de filial deve ser maior que zero',
            'vrAdesao.numeric'              =>'O valor da adesão é inválido',
            'vrAdesao.min'                  =>'O valor da adesão não pode ser negativo',
            'vrContrato.required'           =>'Informe o valor do contrato',
            'vrContrato.numeric'            =>'Valoro do contrato deve ser numérico',
            'vrContrato.min'                =>'Valoro do contrato deve ser maior que zero',
            'isLiberaCatraca.required'      =>'Informq se deve ter catraca liberada ou não',
            //'isLiberaCatraca.boolean'       =>'Valor inválido para liberação da catraca',

        ];
    }
}
