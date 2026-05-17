<?php

namespace Tests\Feature\Seller;

use App\Application\Services\Seller\SellerApplicationService;
use App\Rca;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class StoreSellerControllerTest extends TestCase
{
    //use RefreshDatabase;

    protected SellerApplicationService $sellerApplicationService;
    protected Rca $payload;
    protected Rca $seller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = Rca::factory()->make();
        $this->seller = Rca::factory()->create();
        $user = User::first() ?: factory(User::class)->create();
        Passport::actingAs($user, ['*']);
    }

    public function testCreateANewSeller()
    {
        $data = $this->payload->toArray();

        unset($data['id'], $data['user_id'], $data['user_update_id'], $data['tenant_id']);

        $this->postJson(route('sellers.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'success',
                'data',
            ])->assertJsonPath('success', true)
            ->assertJsonPath('data.filial_id', $data['filial_id'])
            ->assertJsonPath('data.pessoa_id', $data['pessoa_id'])
            ->assertJsonPath('data.situacao', $data['situacao'])
            ->assertJsonPath('data.active', $data['active']);
    }
}
