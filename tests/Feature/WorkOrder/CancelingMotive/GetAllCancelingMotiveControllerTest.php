<?php

namespace Tests\Feature\WorkOrder\CancelingMotive;

use App\MotivoCancelamentoOrdemServico as CancelingMotive;
use App\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCase;

class GetAllCancelingMotiveControllerTest extends TestCase
{
    public function test_can_get_all_canceling_motives(): void
    {
        $user = factory(User::class)->create();
        factory(CancelingMotive::class)->create();

        $this
            ->actingAs($user, 'api')
            ->getJson(route('work-order-canceling-motives.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success',
            ]);
    }
}
