<?php

namespace Tests\Feature\WorkOrder\CancelingMotive;

use App\MotivoCancelamentoOrdemServico as CancelingMotive;
use App\User;
use Tests\TestCase;

class UpdateCancelingMotiveControllerTest extends TestCase
{
    public function test_can_update_canceling_motive(): void
    {
        $user = factory(User::class)->create();
        $cancelingMotive = factory(CancelingMotive::class)->create();

        $payload = [
            'motivo' => 'Updated canceling motive',
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->putJson(route('work-order-canceling-motives.update', ['id' => $cancelingMotive->id]), $payload);

        $response->assertStatus(204);

        $this->assertDatabaseHas($cancelingMotive->getTable(), [
            'id' => $cancelingMotive->id,
            'motivo' => $payload['motivo'],
            'user_update_id' => $user->id,
        ]);
    }
}
