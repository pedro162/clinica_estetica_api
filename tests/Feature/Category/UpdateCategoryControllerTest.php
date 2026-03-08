<?php

namespace Tests\Feature\Category;

use App\Categoria as Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCategoryControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_update_category_returns_no_content(): void
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $payload = [
            'name' => 'Updated Category',
        ];

        $response = $this
            ->actingAs($user, 'api')
            ->putJson(
                route('categories.update', ['id' => $category->id]),
                $payload
            );

        $response->assertStatus(204);
        $this->assertDatabaseHas($category->getTable(), [
            'id' => $category->id,
            'name' => 'Updated Category',
        ]);
    }
}
