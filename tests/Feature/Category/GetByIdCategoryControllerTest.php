<?php

namespace Tests\Feature\Category;

use App\Categoria as Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByIdCategoryControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_get_category_by_id_returns_ok(): void
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->getJson(
                route('categories.show', ['id' => $category->id])
            );

        $response->assertStatus(200);
    }
}
