<?php

namespace Tests\Feature\PaymentMethod;

use App\FormaPagamento;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    protected FormaPagamento $payload;
    protected FormaPagamento $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(FormaPagamento::class)->make();
        $this->paymentMethod = factory(FormaPagamento::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllPaymentMethods()
    {
        $respose = $this->getJson(route('forma_pagamento.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }
    public function testCrateANewPaymentMethod()
    {
        $this->postJson(route('forma_pagamento.store'), $this->payload->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => [
                    'name' => $this->payload->name,
                    'cdCobrancaTipo' => $this->payload->cdCobrancaTipo,
                    'tpPagamento' => $this->payload->tpPagamento,
                ]
            ])->assertJsonPath('data.type', $this->payload->type);
    }

    public function testUpdateAPaymentMethod()
    {
        $this->paymentMethod->name = 'New name';

        $response = $this->putJson(route('forma_pagamento.update', ['id' => $this->paymentMethod->id]), $this->paymentMethod->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), [
            'id' => $this->paymentMethod->id,
            'name' => $this->paymentMethod->name
        ]);
    }

    public function testGetAPaymentMethodById()
    {
        $response = $this->getJson(route('forma_pagamento.show', ['id' => $this->paymentMethod->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->paymentMethod->id);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), [
            'id' => $this->paymentMethod->id
        ]);
    }
}
