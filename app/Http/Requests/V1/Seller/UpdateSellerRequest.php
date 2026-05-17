<?php

namespace App\Http\Requests\V1\Seller;

use App\Utilitarios;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerRequest extends FormRequest
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
            'metaMargem' => 'sometimes|min:0',
            'metaFaturamento' => 'sometimes|min:0',
            'metaPositivacao' => 'sometimes|min:0',
            'situacao' => 'sometimes|in:ativo,inativo',
            'active' => 'sometimes|in:yes,no',
            'acessaTodosRcas' => 'sometimes|in:yes,no',
            'pessoa_id' => 'sometimes|exists:App\Pessoa,id',
            'filial_id' => 'sometimes|exists:App\Filial,id',
            'user_id' => 'sometimes|exists:App\User,id',
            'user_update_id' => 'sometimes|exists:App\User,id',
            'tenant_id' => 'sometimes|exists:App\SimpleTenantDatabase,id',
        ];
    }

    public function prepareForValidation(): void
    {
        $numericFields = [
            'metaMargem',
            'metaFaturamento',
            'metaPositivacao',
        ];

        $data = $this->all();

        foreach ($numericFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = Utilitarios::removeMaskMoney($data[$field]);
            }
        }

        $this->replace($data);
    }
}
