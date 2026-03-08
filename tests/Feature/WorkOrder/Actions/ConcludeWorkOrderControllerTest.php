<?php

namespace Tests\Feature\WorkOrder\Actions;

use App\FormaPagamento;
use App\OperadorFinanceiro;
use App\OrdemServico;
use App\OrdemServicoCobranca;
use App\Pessoa;
use App\PlanoPagamento;
use App\ServicoItem;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConcludeWorkOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_conclude_work_order_returns_ok(): void
    {
        $user = factory(User::class)->create();
        $person = factory(Pessoa::class)->create();

        $user->pessoa_id = $person->id;
        $user->save();
        $user->refresh();

        // explicit payment method, plan and operator to satisfy helper dependencies
        $payment = factory(FormaPagamento::class)->create([
            'hasOperadorFinanceiro' => 'yes',
        ]);
        $plan = factory(PlanoPagamento::class)->create();
        $operator = factory(OperadorFinanceiro::class)->create();

        // create work order with final value defined
        $workOrder = factory(OrdemServico::class)->create([
            'vr_final' => 100,
            'user_id'  => $user->id,
        ]);

        // create at least one service item linked to the order so the helper can conclude correctly
        factory(ServicoItem::class)->create([
            'ordem_servico_id' => $workOrder->id,
            'active'           => 'yes',
        ]);

        // create a charge with the same value as the work order and explicit payment, plan and operator
        factory(OrdemServicoCobranca::class)->create([
            'ordem_servico_id'       => $workOrder->id,
            'filial_id'              => $workOrder->filial_id,
            'forma_pagamento_id'     => $payment->id,
            'plano_pagamento_id'     => $plan->id,
            'operador_financeiro_id' => $operator->id,
            'vr_final'               => 100,
            'user_id'                => $user->id,
        ]);

        $payload = [
            'filial_id' => $workOrder->filial_id,
            'pessoa_id' => $workOrder->pessoa_id,
            'rca_id'    => $workOrder->pessoa_rca_id,
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(
                route('work-orders.conclude', ['id' => $workOrder->id]),
                $payload
            );

        $response->assertStatus(200);
    }
}
