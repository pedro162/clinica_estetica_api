<?php

namespace Tests\Feature\WorkOrder;

use App\OrdemServico;
use App\User;
use Tests\TestCase;

class DeleteWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_delete_work_order_returns_no_content(): void
    {
        $user = factory(User::class)->create();
        $workOrder = factory(OrdemServico::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson(
                route('work-orders.destroy', ['id' => $workOrder->id])
            );

        $response->assertStatus(204);
        $this->assertSoftDeleted($workOrder->getTable(), [
            'id' => $workOrder->id,
        ]);
    }
}
