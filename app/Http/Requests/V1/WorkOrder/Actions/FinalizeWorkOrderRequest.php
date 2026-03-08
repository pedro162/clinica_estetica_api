<?php

namespace App\Http\Requests\V1\WorkOrder\Actions;

use Illuminate\Foundation\Http\FormRequest;

class FinalizeWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filial_id' => 'required|min:1',
            'pessoa_id' => 'required|min:1',
            'rca_id' => 'required|min:1',
        ];
    }
}
