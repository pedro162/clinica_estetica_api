<?php

namespace Tests\Feature\WorkOrder\CancelingMotive;

use App\MotivoCancelamentoOrdemServico as CancelingMotive;
use App\User;
use Tests\TestCase;

class GetByIdCancelingMotiveControllerTest extends TestCase
{
    public function test_can_get_canceling_motive_by_id(): void
    {
        $user = factory(User::class)->create();
        $cancelingMotive = factory(CancelingMotive::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(route('work-order-canceling-motives.show', ['id' => $cancelingMotive->id]));

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.data.id', $cancelingMotive->id);
    }
}
