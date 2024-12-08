<?php

namespace Tests\Feature\Cashier;

use App\Caixa;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CashierTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllCashiers()
    {
        $respose = $this->getJson(route('caixa.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }
    public function testCrateANewCashier()
    {
        $cashier = factory(Caixa::class)->make();
        $this->postJson(route('caixa.store'), $cashier->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => [
                    'name' => $cashier->name,
                    'vrMin' => $cashier->vrMin,
                    'vrMax' => $cashier->vrMax,
                ]
            ])->assertJsonPath('data.type', $cashier->type);
    }

    public function testUpdateACashier()
    {
        $cashier = factory(Caixa::class)->create();
        $cashier->name = 'New name';

        $response = $this->putJson(route('caixa.update', ['id' => $cashier->id]), $cashier->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($cashier->getTable(), [
            'id' => $cashier->id,
            'name' => $cashier->name
        ]);
    }

    public function testGetACashierById()
    {
        $city = factory(Caixa::class)->create();

        $response = $this->getJson(route('caixa.show', ['id' => $city->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $city->id);

        $this->assertDatabaseHas($city->getTable(), [
            'id' => $city->id
        ]);
    }
}
