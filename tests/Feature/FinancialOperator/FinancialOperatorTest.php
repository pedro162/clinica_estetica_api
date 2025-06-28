<?php

namespace Tests\Feature\FinancialOperator;

use App\OperadorFinanceiro;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FinancialOperatorTest extends TestCase
{
    protected OperadorFinanceiro $payload;
    protected OperadorFinanceiro $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(OperadorFinanceiro::class)->make();
        $this->paymentMethod = factory(OperadorFinanceiro::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllFinancialOperators()
    {
        $respose = $this->getJson(route('operador_financeiro.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCrateANewFinancialOperator()
    {
        $data = $this->payload->toArray();
        unset($data['user_id']);
        $this->postJson(route('operador_financeiro.store'), $data)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => $data
            ]);
    }

    public function testUpdateAFinancialOperator()
    {
        $this->paymentMethod->qtdDiasProtesto = 5;
        $data = $this->paymentMethod->toArray();

        $response = $this->putJson(route('operador_financeiro.update', ['id' => $this->paymentMethod->id]), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), ['id' => $data['id'], 'qtdDiasProtesto' => $data['qtdDiasProtesto']]);
    }

    public function testGetAFinancialOperatorById()
    {
        $response = $this->getJson(route('operador_financeiro.show', ['id' => $this->paymentMethod->id]));

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
