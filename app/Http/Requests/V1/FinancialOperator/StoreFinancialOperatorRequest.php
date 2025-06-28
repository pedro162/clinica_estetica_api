<?php

namespace App\Http\Requests\V1\FinancialOperator;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinancialOperatorRequest extends FormRequest
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
            'vrTarifa' => 'sometimes|numeric|min:0',
            'vrDesconto' => 'sometimes|numeric|min:0',
            'vrPorcentagemDesconto' => 'sometimes|nullable|numeric|min:0|max:100',
            'nrRemessaAtual' => 'sometimes|nullable|integer|min:0',
            'nrNossoNumero' => 'sometimes|nullable|integer|min:0',
            'qtdDiasProtesto' => 'sometimes|nullable|integer|min:0|max:1000',
            'isAssumeDuplicata' => 'sometimes|in:yes,no',
            'tpLocalAtualizacaoBoleto' => 'sometimes|in:empresa,banco',
            'isPadrao' => 'sometimes|in:yes,no',
            'isLiberado' => 'sometimes|in:yes,no',
            'pessoa_id' => 'sometimes|exists:App\Pessoa,id',
            'filial_id' => 'sometimes|exists:App\Filial,id',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
        ];
    }
}
