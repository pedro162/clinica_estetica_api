<?php

namespace App\Http\Requests\V1\PaymentPlan;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentPlanRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:255',
            'descricao' => 'required|string|min:1|max:255',
            'diasmedios' => 'required|integer|min:1|max:30',
            'qtdParcelas' => 'required|integer|min:1|max:100',
            'desdobrarDuplicataManual' => 'sometimes|in:yes,no',
            'gerarDuplicataManual' => 'sometimes|in:yes,no',
            'isAtiva' => 'sometimes|in:yes,no',
            'isAberto' => 'sometimes|in:yes,no',
            'qtdMinParcelas' => 'required|integer|min:1|max:100',
            'qtd_dias_pri_parcela' => 'required|integer|min:0|max:100',
            'qtdDiasIntervaloParcelas' => 'required|integer|min:0|max:100',
            'exibe_balcao' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
        ];
    }
}
