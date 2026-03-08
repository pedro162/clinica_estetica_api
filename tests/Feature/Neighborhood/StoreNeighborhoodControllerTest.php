<?php

namespace Tests\Feature\Neighborhood;

use App\Bairro as Neighborhood;
use App\User;
use Tests\TestCase;

class StoreNeighborhoodControllerTest extends TestCase
{
    public function test_can_store_neighborhood(): void
    {
        $user = factory(User::class)->create();
        $neighborhood = factory(Neighborhood::class)->create();

        $payload = factory(Neighborhood::class)->make()->toArray();
        unset($payload['id'], $payload['user_id'], $payload['user_update_id'], $payload['tenant_id']);

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(
                route('neighborhoods.store'),
                $payload
            );

        $response->assertStatus(201);
        $this->assertDatabaseHas($neighborhood->getTable(), [
            'name' => $payload['name'],
        ]);
    }
}
