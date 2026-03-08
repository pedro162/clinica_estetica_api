<?php

namespace App\Http\Requests\V1\Neighborhood;

use Illuminate\Foundation\Http\FormRequest;

class DestroyNeighborhoodRequest extends FormRequest
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
