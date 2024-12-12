<?php

namespace Tests\Feature\AccountReceivable;

use App\ContaReceber;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class AccountReceivableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        //Artisan::call('migrate:refresh --force');
        //Artisan::call('migrate');

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllAccountReceivables()
    {
        $response = $this->getJson(route('receber.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }
    public function testCrateANewAccountReceivable()
    {
        $cashier = factory(ContaReceber::class)->make();
        $this->postJson(route('receber.store'), $cashier->toArray())
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

    public function testUpdateAAccountReceivable()
    {
        $cashier = factory(ContaReceber::class)->create();
        $cashier->name = 'New name';

        $response = $this->putJson(route('receber.update', ['id' => $cashier->id]), $cashier->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($cashier->getTable(), [
            'id' => $cashier->id,
            'name' => $cashier->name
        ]);
    }

    public function testGetAAccountReceivableById()
    {
        $city = factory(ContaReceber::class)->create();

        $response = $this->getJson(route('receber.show', ['id' => $city->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $city->id);

        $this->assertDatabaseHas($city->getTable(), [
            'id' => $city->id
        ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        //Artisan::call('migrate:rollback');
    }
}
