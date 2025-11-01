<?php

namespace App\Http\Requests\V1\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
            'name' => 'required|min:1|max:255',
            'cdCobrancaTipo' => 'sometimes|min:1|max:255',
            'hasComissao' => 'sometimes|in:yes,no',
            'tpPagamento' => 'sometimes|in:a vista,a prazo,cartao',
            'hasDesdobramento' => 'sometimes|in:yes,no',
            'hasLimiteDeCredito' => 'sometimes|in:yes,no',
            'hasAcertoBalcao' => 'sometimes|in:yes,no',
            'hasAcertoCaixa' => 'sometimes|in:yes,no',
            'hasEntrada' => 'sometimes|in:yes,no',
            'tipo' => 'sometimes|in:cartao_credito,cartao_debito,boleto,dinheiro',
            'hasOperadorFinanceiro' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
            'operador_financeiro_id' => 'sometimes|array',
            'operador_financeiro_id.*' => 'distinct|exists:App\OperadorFinanceiro,id',
            'plano_pagamento_id' => 'sometimes|array',
            'plano_pagamento_id.*' => 'distinct|exists:App\PlanoPagamento,id',
        ];
    }
}
