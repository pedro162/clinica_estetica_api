<?php

namespace Tests\Feature\WorkOrder\Actions;

use App\OrdemServico;
use App\Servico;
use App\User;
use Tests\TestCase;

class AddItemWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_add_item_to_work_order_returns_ok(): void
    {
        $user = factory(User::class)->create();
        $workOrder = factory(OrdemServico::class)->create();
        $service = factory(Servico::class)->create();

        $payload = [
            'servico_id' => $service->id,
            'qtd' => 1,
            'vrItem' => 100,
            'pct_desconto' => 0,
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(
                route('work-orders.add-item', ['id' => $workOrder->id]),
                $payload
            );

        $response->assertStatus(200);
    }
}
