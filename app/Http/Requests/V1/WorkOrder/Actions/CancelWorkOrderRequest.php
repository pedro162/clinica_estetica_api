<?php

namespace App\Http\Requests\V1\WorkOrder\Actions;

use Illuminate\Foundation\Http\FormRequest;

class CancelWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'motivo_cancel_id' => 'required|min:1',
        ];
    }
}
