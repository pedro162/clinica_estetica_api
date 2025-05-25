<?php

namespace App\Http\Requests\V1\FinancialOperator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinancialOperatorRequest extends FormRequest
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
            'vrTarifa' => 'sometimes|float|min:0',
            'vrDesconto' => 'sometimes|float|min:0',
            'vrPorcentagemDesconto' => 'sometimes|float|min:0|max:100',
            'nrRemessaAtual' => 'sometimes|string',
            'nrNossoNumero' => 'sometimes|string',
            'qtdDiasProtesto' => 'sometimes|integer|min:1|max:1000',
            'isAssumeDuplicata' => 'sometimes|in:yes,no',
            'tpLocalAtualizacaoBoleto' => 'sometimes|string',
            'isPadrao' => 'sometimes|in:yes,no',
            'isLiberado' => 'sometimes|in:yes,no',
            'pessoa_id' => 'sometimes|exists:App\Pessoa,id',
            'filial_id' => 'sometimes|exists:App\Filial,id',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
        ];
    }
}
