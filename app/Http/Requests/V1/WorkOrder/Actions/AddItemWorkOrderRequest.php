<?php

namespace App\Http\Requests\V1\WorkOrder\Actions;

use Illuminate\Foundation\Http\FormRequest;

class AddItemWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'servico_id' => 'required|min:1',
            'qtd' => 'required|min:1',
            'vrItem' => 'required|min:0.01',
            'pct_desconto' => 'max:100',
        ];
    }
}
