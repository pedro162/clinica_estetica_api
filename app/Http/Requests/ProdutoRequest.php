<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class ProdutoRequest extends FormRequest
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
            'name'=>'required',
            'description'=>'required',
            'marca_id'=>'required',
            'imagem'=>'required',
            'categoria_id'=>'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Informe o nome do produto',
            'description.required'=>'Informe uma descrição para o produto',
            'marca_id.required'=>'Informe uma marca para o produto',
            'imagem.required'=>'Carregue uma imagem para o produto',
            'categoria_id.required'=>'Informe uma categoria para o produto'

        ];
    }


}
