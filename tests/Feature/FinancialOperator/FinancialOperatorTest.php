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
        $this->postJson(route('operador_financeiro.store'), $this->payload->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => [
                    'qtdDiasProtesto' => $this->payload->qtdDiasProtesto,
                    'nrNossoNumero' => $this->payload->nrNossoNumero,
                    'nrRemessaAtual' => $this->payload->nrRemessaAtual,
                ]
            ])->assertJsonPath('data.type', $this->payload->type);
    }

    public function testUpdateAFinancialOperator()
    {
        $this->paymentMethod->qtdDiasProtesto = 5;
        $response = $this->putJson(route('operador_financeiro.update', ['id' => $this->paymentMethod->id]), $this->paymentMethod->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($this->paymentMethod->getTable(), [
            'id' => $this->paymentMethod->id,
            'qtdDiasProtesto' => $this->paymentMethod->qtdDiasProtesto
        ]);
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
