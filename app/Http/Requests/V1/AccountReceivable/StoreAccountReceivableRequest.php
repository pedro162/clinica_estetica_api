<?php

namespace App\Http\Requests\V1\AccountReceivable;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountReceivableRequest extends FormRequest
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
            'referencia_id' => 'sometimes',
            'referencia' => 'sometimes',
            'pessoa_id' => 'sometimes|exists:App\Pessoa,id',
            'descricao' => 'sometimes',
            'documento' => 'sometimes',
            'dtVencimentoOriginal' => 'sometimes',
            'dtVencimento' => 'sometimes',
            'vrBruto' => 'sometimes',
            'vrLiquido' => 'sometimes',
            'vrDevolvido' => 'sometimes',
            'vrPago' => 'sometimes',
            'vrTaxa' => 'sometimes',
            'vrDesconto' => 'sometimes',
            'vrJuros' => 'sometimes',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'nullable|sometimes|exists:App\User,id',
            'active' => 'sometimes',
            'responsavel_id' => 'sometimes|exists:App\Pessoa,id',
            'importacao_dados' => 'sometimes',
            'forma_pagamento_id' => 'sometimes|exists:App\FormaPagamento,id',
            'plano_pagamento_id' => 'sometimes|exists:App\PlanoPagamento,id',
            'operador_financeiro_id' => 'sometimes|exists:App\OperadorFinanceiro,id',
            'status' => 'sometimes',
        ];
    }
}
