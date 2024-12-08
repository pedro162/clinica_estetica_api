<?php

namespace App\Http\Requests\V1\Cashier;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashierRequest extends FormRequest
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
            'type' => 'sometimes|in:convencional,banco',
            'vrMin' => 'sometimes|min:0',
            'vrMax' => 'sometimes|min:0',
            'vrSaldo' => 'sometimes|min:0',
            'status_abertura' => 'sometimes|in:open,close',
            'tpSaldo' => 'sometimes|in:positivo,negativo',
            'status_bloqueio' => 'sometimes|in:bloqueado,liberado',
            'aceita_transferencia' => 'sometimes|in:yes,no',
            'filial_id' => 'sometimes|exists:App\Filial,id'
        ];
    }
}
