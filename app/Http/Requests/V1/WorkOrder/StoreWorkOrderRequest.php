<?php

namespace App\Http\Requests\V1\WorkOrder;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $numericFields = [
            'vrTotal',
            'vr_final',
            'vr_desconto',
            'pct_acrescimo',
            'vr_acrescimo',
            'pct_desconto',
        ];

        $idFields = [
            'pessoa_id',
            'pessoa_rca_id',
            'filial_id',
            'pess_fat_id',
            'pess_cancel_id',
            'pess_concl_id',
            'profissional_id',
            'mt_calcel_id',
            'user_id',
            'user_update_id',
            'tenant_id',
        ];

        $data = $this->all();

        foreach ($numericFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = str_replace(['.', ','], ['', '.'], preg_replace('/[^0-9,\.]/', '', $data[$field]));
            }
        }

        foreach ($idFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = preg_replace('/\D+/', '', $data[$field]);
            }
        }

        $this->replace($data);
    }

    public function rules(): array
    {
        return [
            // valores monetarios
            'vrTotal'        => 'required|numeric|min:0',
            'vr_final'       => 'sometimes|numeric|min:0',
            'vr_desconto'    => 'sometimes|numeric|min:0',
            'pct_acrescimo'  => 'sometimes|numeric|min:0',
            'vr_acrescimo'   => 'sometimes|numeric|min:0',
            'pct_desconto'   => 'sometimes|numeric|min:0',

            // status e flags
            'status'         => 'required|string|in:aberto,cancelado,aguardando,concluido',
            'observacao'     => 'sometimes|nullable|string',
            'dsArquivo'      => 'sometimes|nullable|string',
            'active'         => 'sometimes|in:yes,no',
            'is_faturado'    => 'sometimes|in:yes,no',
            'is_orcamento'   => 'sometimes|in:yes,no',
            'type'           => 'sometimes|string',

            // datas
            'td_faturamento' => 'sometimes|nullable|date',
            'td_cancelamento' => 'sometimes|nullable|date',
            'td_conclusao'   => 'sometimes|nullable|date',

            // relacionamentos obrigatorios para criacao
            'pessoa_id'      => 'required|exists:App\\Pessoa,id',
            'pessoa_rca_id'  => 'required|exists:App\\Rca,id',
            'filial_id'      => 'required|exists:App\\Filial,id',

            // relacionamentos opcionais
            'pess_fat_id'    => 'sometimes|nullable|exists:App\\Pessoa,id',
            'pess_cancel_id' => 'sometimes|nullable|exists:App\\Pessoa,id',
            'pess_concl_id'  => 'sometimes|nullable|exists:App\\Pessoa,id',
            'profissional_id' => 'sometimes|nullable|integer',
            'mt_calcel_id'   => 'sometimes|nullable|integer',

            // controle de usuario / tenant
            'user_id'        => 'required|exists:App\\User,id',
            'user_update_id' => 'sometimes|exists:App\\User,id',
            'tenant_id'      => 'sometimes|exists:App\\SimpleTenantDatabase,id',
        ];
    }
}
