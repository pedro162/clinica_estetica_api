<?php

namespace App\Http\Requests\V1\Neighborhood;

use Illuminate\Foundation\Http\FormRequest;

class StoreNeighborhoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cep' => isset($this->cep) ? (string) preg_replace('/\D+/', '', $this->cep) : null,
            'codIbge' => isset($this->codIbge) ? (string) preg_replace('/\D+/', '', $this->codIbge) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'codIbge' => 'sometimes|string|max:255',
            'cep' => 'sometimes|string|max:255',
            'active' => 'sometimes|in:yes,no',
            'cidade_id' => 'sometimes|exists:App\\Cidade,id',
            'user_id' => 'sometimes|exists:App\\User,id',
            'user_update_id' => 'sometimes|exists:App\\User,id',
            'tenant_id' => 'sometimes|exists:App\\SimpleTenantDatabase,id',
        ];
    }
}
