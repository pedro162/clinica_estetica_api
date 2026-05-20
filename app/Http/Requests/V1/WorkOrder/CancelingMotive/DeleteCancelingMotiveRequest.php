<?php

namespace App\Http\Requests\V1\WorkOrder\CancelingMotive;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCancelingMotiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
