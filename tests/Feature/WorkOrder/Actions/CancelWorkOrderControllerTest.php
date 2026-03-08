<?php

namespace Tests\Feature\WorkOrder\Actions;

use App\MotivoCancelamentoOrdemServico;
use App\OrdemServico;
use App\Pessoa;
use App\User;
use Tests\TestCase;

class CancelWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_cancel_work_order_returns_ok(): void
    {
        $user = factory(User::class)->create();
        $person = factory(Pessoa::class)->create();

        $user->pessoa_id = $person->id;
        $user->save();
        $user->refresh();

        $workOrder = factory(OrdemServico::class)->create([
            'tenant_id' => $user->tenant_id,
            'user_id'   => $user->id,
        ]);

        $reason = factory(MotivoCancelamentoOrdemServico::class)->create([
            'active'    => 'yes',
            'user_id'   => $user->id,
        ]);

        $payload = [
            'motivo_cancel_id' => $reason->id,
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(
                route('work-orders.cancel', ['id' => $workOrder->id]),
                $payload
            );

        $response->assertStatus(200);
    }
}
