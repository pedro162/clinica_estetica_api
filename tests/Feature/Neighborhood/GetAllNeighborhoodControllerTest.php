<?php

namespace Tests\Feature\Neighborhood;

use App\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCase;

class GetAllNeighborhoodControllerTest extends TestCase
{
    public function test_can_get_all_neighborhoods(): void
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(route('neighborhoods.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }
}
