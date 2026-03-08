<?php

namespace Tests\Feature\Neighborhood;

use App\Bairro as Neighborhood;
use App\User;
use Tests\TestCase;

class DeleteNeighborhoodControllerTest extends TestCase
{
    public function test_can_delete_neighborhood(): void
    {
        $user = factory(User::class)->create();
        $neighborhood = factory(Neighborhood::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson(
                route('neighborhoods.destroy', ['id' => $neighborhood->id])
            );

        $response->assertStatus(204);
        $this->assertSoftDeleted($neighborhood->getTable(), [
            'id' => $neighborhood->id,
        ]);
    }
}
