<?php

namespace Tests\Feature\WorkOrder;

use App\OrdemServico;
use App\User;
use Tests\TestCase;

class GetByIdWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_get_work_order_by_id_returns_ok(): void
    {
        $user = factory(User::class)->create();
        $workOrder = factory(OrdemServico::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(
                route('work-orders.show', ['id' => $workOrder->id])
            );

        $response->assertStatus(200);
    }
}
