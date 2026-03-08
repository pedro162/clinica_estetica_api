<?php

namespace Tests\Feature\WorkOrder;

use App\OrdemServico;
use App\User;
use Tests\TestCase;

class StoreWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_store_work_order_returns_created(): void
    {
        $user = factory(User::class)->create();

        /** @var OrdemServico $os */
        $os = factory(OrdemServico::class)->make();

        $payload = [
            'vrTotal'       => $os->vrTotal,
            'status'        => $os->status,
            'observacao'    => $os->observacao,
            'dsArquivo'     => $os->dsArquivo,
            'pessoa_id'     => $os->pessoa_id,
            'pessoa_rca_id' => $os->pessoa_rca_id,
            'filial_id'     => $os->filial_id,
            'user_id'       => $user->id,
            'user_update_id' => $user->id,
            'active'        => $os->active,
            'vr_final'      => $os->vr_final,
            'vr_desconto'   => $os->vr_desconto,
            'pct_acrescimo' => $os->pct_acrescimo,
            'vr_acrescimo'  => $os->vr_acrescimo,
            'pct_desconto'  => $os->pct_desconto,
            'is_faturado'   => $os->is_faturado,
            'td_faturamento' => $os->td_faturamento,
            'td_cancelamento' => $os->td_cancelamento,
            'td_conclusao'  => $os->td_conclusao,
            'pess_fat_id'   => $os->pess_fat_id,
            'pess_cancel_id' => $os->pess_cancel_id,
            'pess_concl_id' => $os->pess_concl_id,
            'profissional_id' => $os->profissional_id,
            'mt_calcel_id'  => $os->mt_calcel_id,
            'type'          => $os->type,
            'is_orcamento'  => $os->is_orcamento,
            'tenant_id'     => $os->tenant_id,
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(
                route('work-orders.store'),
                $payload
            );

        $response->assertStatus(201);
        $this->assertDatabaseHas((new OrdemServico())->getTable(), [
            'pessoa_id' => $payload['pessoa_id'],
            'filial_id' => $payload['filial_id'],
            'active'    => $payload['active'],
        ]);
    }
}
