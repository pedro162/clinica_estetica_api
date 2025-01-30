<?php

namespace App\Http\Requests\V1\AccountReceivableItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountReceivableItemRequest extends FormRequest
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
            'filial_id' => 'sometimes|exists:App\Filial,id',
            'referencia_id' => 'nullable|sometimes',
            'referencia' => 'nullable|sometimes',
            'pessoa_id' => 'sometimes|exists:App\Pessoa,id',
            'pessoa_baixa_id' => 'nullable|sometimes|exists:App\Pessoa,id',
            'pessoa_devolucao_id' => 'nullable|sometimes|exists:App\Pessoa,id',
            'pessoa_estorno_id' => 'nullable|sometimes|exists:App\Pessoa,id',
            'caixa_id' => 'nullable|sometimes|exists:App\Caixa,id',
            'conta_receber_id' => 'sometimes|exists:App\ContaReceber,id',
            'descricao' => 'nullable|sometimes',
            'documento' => 'sometimes',
            'vrBruto' => 'sometimes',
            'vrLiquido' => 'sometimes',
            'vrDevolvido' => 'nullable|sometimes',
            'vrPago' => 'nullable|sometimes',
            'vrTaxa' => 'nullable|sometimes',
            'vrDesconto' => 'nullable|sometimes',
            'vrJuros' => 'nullable|sometimes',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'nullable|sometimes|exists:App\User,id',
            'active' => 'nullable|sometimes',
            'ds_estorno' => 'nullable|sometimes',
            'forma_pagamentos_id' => 'sometimes|exists:App\FormaPagamento,id',
            'plano_pagamento_id' => 'sometimes|exists:App\PlanoPagamento,id',
            'operador_financeiro_id' => 'sometimes|exists:App\OperadorFinanceiro,id',
            'bandeira_cartao_id' => 'nullable|sometimes|exists:App\BandeiraCartao,id',
            'status' => 'nullable|sometimes',
            'dtPagamento' => 'nullable|sometimes|date|date_format:Y-m-d',
            'dtBaixa' => 'nullable|sometimes|date|date_format:Y-m-d',
            'tpBaixa' => 'nullable|sometimes',
        ];
    }
}
