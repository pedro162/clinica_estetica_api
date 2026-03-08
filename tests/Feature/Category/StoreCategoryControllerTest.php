<?php

namespace Tests\Feature\Category;

use App\Categoria as Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCategoryControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_store_category_returns_created(): void
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $payload = [
            'name' => 'Test Category',
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->postJson(
                route('categories.store'),
                $payload
            );

        $response->assertStatus(201);
        $this->assertDatabaseHas($category->getTable(), [
            'name' => 'Test Category',
        ]);
    }
}
