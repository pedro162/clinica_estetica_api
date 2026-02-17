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

class GetByIdServiceControllerTest extends TestCase
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

    public function testGetAServicesById()
    {
        $data = $this->seller->toArray();
        $response = $this->getJson(route('sellers.info', ['id' => $this->seller->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->seller->id)
            ->assertJson([
                'data' => $data
            ]);

        $this->assertDatabaseHas($this->seller->getTable(), $data);
    }
}
