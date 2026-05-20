<?php

namespace Tests\Feature\WorkOrder\CancelingMotive;

use App\MotivoCancelamentoOrdemServico as CancelingMotive;
use App\User;
use Tests\TestCase;

class StoreCancelingMotiveControllerTest extends TestCase
{
    public function test_can_store_canceling_motive(): void
    {
        $user = factory(User::class)->create();
        $cancelingMotive = factory(CancelingMotive::class)->create();

        $payload = factory(CancelingMotive::class)->make()->toArray();
        unset($payload['id'], $payload['user_id'], $payload['user_update_id'], $payload['tenant_id'], $payload['active']);

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(route('work-order-canceling-motives.store'), $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas($cancelingMotive->getTable(), [
            'motivo' => $payload['motivo'],
            'user_id' => $user->id,
            'active' => 'yes',
        ]);
    }
}
