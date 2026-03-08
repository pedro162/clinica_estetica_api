<?php

namespace Tests\Feature\WorkOrder;

use App\OrdemServico;
use App\User;
use Tests\TestCase;

class UpdateWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_update_work_order_returns_no_content(): void
    {
        $user = factory(User::class)->create();
        $workOrder = factory(OrdemServico::class)->create();

        // apenas atualiza o campo active, demais campos permanecem inalterados
        $payload = [
            'active' => 'no',
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->putJson(
                route('work-orders.update', ['id' => $workOrder->id]),
                $payload
            );

        $response->assertStatus(204);
        $this->assertDatabaseHas($workOrder->getTable(), [
            'id' => $workOrder->id,
            'active' => 'no',
        ]);
    }
}
