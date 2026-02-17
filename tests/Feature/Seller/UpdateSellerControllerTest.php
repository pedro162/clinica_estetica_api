<?php

namespace Tests\Feature\Service;

use App\Application\Services\Service\ServiceApplicationService;
use App\Rca;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Tests\Feature\SetupTest;

class UpdateServiceControllerTest extends TestCase
{
    //use RefreshDatabase;

    protected ServiceApplicationService $sellerApplicationService;
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

    public function testUpdateService()
    {
        $data = $this->payload->toArray();
        unset($data['id'], $data['user_id'], $data['user_update_id']);

        $response = $this->putJson(route('sellers.update', ['id' => $this->seller->id]), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);
        $this->assertDatabaseHas(
            $this->seller->getTable(),
            array_merge($data, ['id' => $this->seller->id])
        );
    }
}
