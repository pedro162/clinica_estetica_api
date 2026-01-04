<?php

namespace Tests\Feature\Service;

use App\Application\Services\Service\ServiceApplicationService;
use App\Servico;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Tests\Feature\SetupTest;

class StoreServiceControllerTest extends TestCase
{
    //use RefreshDatabase;

    protected ServiceApplicationService $serviceApplicationService;
    protected Servico $payload;
    protected Servico $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = Servico::factory()->make();
        $this->service = Servico::factory()->create();
        $user = User::first() ?: factory(User::class)->create();
        Passport::actingAs($user, ['*']);
    }

    public function testCreateANewService()
    {
        $data = $this->payload->toArray();

        unset($data['id'], $data['user_id'], $data['user_update_id'], $data['tenant_id']);

        $this->postJson(route('servico.store'), $data)
            ->assertJsonStructure([
                'success',
                'data',
            ])->assertJson([
                'data' => $data
            ])->assertStatus(JsonResponse::HTTP_CREATED);
    }
}
