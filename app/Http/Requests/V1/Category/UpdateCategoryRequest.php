<?php

namespace App\Http\Requests\V1\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'tenant_id' => ['sometimes', 'integer', 'exists:App\SimpleTenantDatabase,id'],
        ];
    }
}
