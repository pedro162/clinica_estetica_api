<?php

namespace Tests\Feature\Neighborhood;

use App\Bairro as Neighborhood;
use App\User;
use Tests\TestCase;

class GetByIdNeighborhoodControllerTest extends TestCase
{
    public function test_can_get_neighborhood_by_id(): void
    {
        $user = factory(User::class)->create();
        $neighborhood = factory(Neighborhood::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(
                route('neighborhoods.show', ['id' => $neighborhood->id])
            );

        $response->assertStatus(200);
    }
}
