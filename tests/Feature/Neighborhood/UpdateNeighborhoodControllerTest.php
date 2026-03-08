<?php

namespace Tests\Feature\Neighborhood;

use App\Bairro as Neighborhood;
use App\User;
use Tests\TestCase;

class UpdateNeighborhoodControllerTest extends TestCase
{
    public function test_can_update_neighborhood(): void
    {
        $user = factory(User::class)->create();
        $neighborhood = factory(Neighborhood::class)->create();

        $payload = [
            'name' => 'Updated Neighborhood',
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->putJson(
                route('neighborhoods.update', ['id' => $neighborhood->id]),
                $payload
            );

        $response->assertStatus(204);
        $this->assertDatabaseHas($neighborhood->getTable(), [
            'id' => $neighborhood->id,
            'name' => 'Updated Neighborhood',
        ]);
    }
}
