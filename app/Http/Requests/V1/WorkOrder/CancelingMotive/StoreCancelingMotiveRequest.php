<?php

namespace App\Http\Requests\V1\WorkOrder\CancelingMotive;

use Illuminate\Foundation\Http\FormRequest;

class StoreCancelingMotiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'motivo' => 'required|min:1',
        ];
    }
}
