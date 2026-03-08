<?php

namespace Tests\Feature\Category;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllCategoryControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_get_all_categories_returns_ok(): void
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(route('categories.index'));

        $response->assertStatus(200);
    }
}
