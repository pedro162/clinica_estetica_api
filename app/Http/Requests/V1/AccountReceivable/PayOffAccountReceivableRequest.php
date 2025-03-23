<?php

namespace App\Http\Requests\V1\AccountReceivable;

use Illuminate\Foundation\Http\FormRequest;

class PayOffAccountReceivableRequest extends FormRequest
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
            'id' => 'sometimes|exists:App\ContaReceber,id',
            'caixa_id' => 'sometimes|exists:App\Caixa,id',
            'vr_acrescimo' => 'sometimes|numeric:min:0',
            'vr_desconto' => 'sometimes|numeric:min:0',
            'vr_final' => 'sometimes|numeric:min:0',
            'vr_juros' => 'sometimes|numeric:min:0',
            'vr_multa' => 'sometimes|numeric:min:0',
            'vr_pago' => 'sometimes|numeric:min:0',
            'ds_observacao' => 'required|max:255|min:2',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'nullable|sometimes|exists:App\User,id'
        ];
    }
}
