<?php

namespace Tests\Feature\Category;

use App\Categoria as Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCategoryControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function test_delete_category_returns_no_content(): void
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson(
                route('categories.destroy', ['id' => $category->id])
            );

        $response->assertStatus(204);
        $this->assertSoftDeleted($category->getTable(), [
            'id' => $category->id,
        ]);
    }
}
