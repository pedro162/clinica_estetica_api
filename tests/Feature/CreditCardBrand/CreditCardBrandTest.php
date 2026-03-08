<?php

namespace Tests\Feature\CreditCardBrand;

use App\BandeiraCartao;
use App\User;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CreditCardBrandTest extends TestCase
{
    protected BandeiraCartao $payload;
    protected BandeiraCartao $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(BandeiraCartao::class)->make();
        $this->paymentMethod = factory(BandeiraCartao::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllCreditCardBrands()
    {
        $respose = $this->getJson(route('bandeira_cartao.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCrateANewCreditCardBrand()
    {
        $this->postJson(route('bandeira_cartao.store'), $this->payload->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => [
                    'name' => $this->payload->name,
                ]
            ])->assertJsonPath('data.name', $this->payload->name);
    }

    public function testUpdateACreditCardBrand()
    {
        $this->paymentMethod->name = 'New name';
        $response = $this->putJson(route('bandeira_cartao.update', ['id' => $this->paymentMethod->id]), $this->paymentMethod->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), [
            'id' => $this->paymentMethod->id,
            'name' => $this->paymentMethod->name
        ]);
    }

    public function testGetACreditCardBrandById()
    {
        $response = $this->getJson(route('bandeira_cartao.show', ['id' => $this->paymentMethod->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->paymentMethod->id);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), [
            'id' => $this->paymentMethod->id
        ]);
    }

    public function testDeleteACreditCardBrand()
    {
        $response = $this->getJson(route('bandeira_cartao.destroy', ['id' => $this->paymentMethod->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), [
            'id' => $this->paymentMethod->id,
            'active' => 'no'
        ]);
    }
}
