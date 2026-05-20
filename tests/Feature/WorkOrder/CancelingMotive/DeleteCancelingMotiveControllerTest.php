<?php

namespace Tests\Feature\WorkOrder\CancelingMotive;

use App\MotivoCancelamentoOrdemServico as CancelingMotive;
use App\User;
use Tests\TestCase;

class DeleteCancelingMotiveControllerTest extends TestCase
{
    public function test_can_delete_canceling_motive(): void
    {
        $user = factory(User::class)->create();
        $cancelingMotive = factory(CancelingMotive::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson(route('work-order-canceling-motives.destroy', ['id' => $cancelingMotive->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted($cancelingMotive->getTable(), [
            'id' => $cancelingMotive->id,
        ]);

        $this->assertDatabaseHas($cancelingMotive->getTable(), [
            'id' => $cancelingMotive->id,
            'active' => 'no',
        ]);
    }
}
