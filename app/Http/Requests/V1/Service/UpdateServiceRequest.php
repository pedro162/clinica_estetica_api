<?php

namespace App\Http\Requests\V1\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'name' => 'sometimes|min:1|max:255',
            'descricao' => 'sometimes|nullable|min:1|max:255',
            'unidade' => 'sometimes|nullable|min:1|max:255',
            'type' => 'sometimes|nullable|in:mensalidade,outros',
            'vrServico' => 'sometimes|min:0',
            'active' => 'sometimes|in:yes,no',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
            'tenant_id' => 'sometimes|exists:App\SimpleTenantDatabase,id',
        ];
    }
}
