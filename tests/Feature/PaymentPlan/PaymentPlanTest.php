<?php

namespace Tests\Feature\PaymentPlan;

use App\PlanoPagamento;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentPlanTest extends TestCase
{
    protected PlanoPagamento $payload;
    protected PlanoPagamento $paymentPlan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = factory(PlanoPagamento::class)->make();
        $this->paymentPlan = factory(PlanoPagamento::class)->create();

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllPaymentPlans()
    {
        $respose = $this->getJson(route('plano_pagamento.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCrateANewPaymentPlan()
    {
        $this->postJson(route('plano_pagamento.store'), $this->payload->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJson([
                'data' => [
                    'name' => $this->payload->name,
                    'descricao' => $this->payload->descricao,
                    'diasmedios' => $this->payload->diasmedios,
                    'qtdParcelas' => $this->payload->qtdParcelas,
                    'desdobrarDuplicataManual' => $this->payload->desdobrarDuplicataManual,
                    'gerarDuplicataManual' => $this->payload->gerarDuplicataManual,
                    'isAtiva' => $this->payload->isAtiva,
                    'isAberto' => $this->payload->isAberto,
                    'qtdMinParcelas' => $this->payload->qtdMinParcelas,
                    'qtd_dias_pri_parcela' => $this->payload->qtd_dias_pri_parcela,
                    'qtdDiasIntervaloParcelas' => $this->payload->qtdDiasIntervaloParcelas,
                    'exibe_balcao' => $this->payload->exibe_balcao,
                ]
            ]);
    }

    public function testUpdateAPaymentPlan()
    {
        $this->paymentPlan->name = 'New name';
        $response = $this->putJson(route('plano_pagamento.update', ['id' => $this->paymentPlan->id]), $this->paymentPlan->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas(
            $this->paymentPlan->getTable(),
            [
                'name' => $this->paymentPlan->name,
                'descricao' => $this->paymentPlan->descricao,
                'diasmedios' => $this->paymentPlan->diasmedios,
                'qtdParcelas' => $this->paymentPlan->qtdParcelas,
                'desdobrarDuplicataManual' => $this->paymentPlan->desdobrarDuplicataManual,
                'gerarDuplicataManual' => $this->paymentPlan->gerarDuplicataManual,
                'isAtiva' => $this->paymentPlan->isAtiva,
                'isAberto' => $this->paymentPlan->isAberto,
                'qtdMinParcelas' => $this->paymentPlan->qtdMinParcelas,
                'qtd_dias_pri_parcela' => $this->paymentPlan->qtd_dias_pri_parcela,
                'qtdDiasIntervaloParcelas' => $this->paymentPlan->qtdDiasIntervaloParcelas,
                'exibe_balcao' => $this->paymentPlan->exibe_balcao,
            ]
        );
    }

    public function testGetAPaymentPlanById()
    {
        $response = $this->getJson(route('plano_pagamento.show', ['id' => $this->paymentPlan->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $this->paymentPlan->id);

        $this->assertDatabaseHas($this->paymentPlan->getTable(), [
            'id' => $this->paymentPlan->id
        ]);
    }
}
