<?php

namespace Tests\Feature\WorkOrder;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllWorkOrderControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_get_all_work_orders_returns_ok(): void
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(route('work-orders.index'));

        $response->assertStatus(200);
    }
}
