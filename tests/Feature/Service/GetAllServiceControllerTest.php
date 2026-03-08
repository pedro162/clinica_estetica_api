<?php

namespace Tests\Feature\Service;

use App\Application\Services\Service\ServiceApplicationService;
use App\Servico;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetAllServiceControllerTest extends TestCase
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

    public function testGetAllServices()
    {
        $response = $this->getJson(route('servico.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }
}
