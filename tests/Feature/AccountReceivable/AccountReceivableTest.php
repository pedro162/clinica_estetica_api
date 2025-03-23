<?php

namespace Tests\Feature\AccountReceivable;

use App\BandeiraCartao;
use App\Caixa;
use App\ContaReceber;
use App\FormaPagamento;
use App\OperadorFinanceiro;
use App\PlanoPagamento;
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
        $accountReceivable = factory(ContaReceber::class)->make();
        $methodOfPayment = factory(FormaPagamento::class)->create(['tipo' => 'dinheiro']);
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamento_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;

        $response = $this->postJson(route('receber.store'), $accountReceivable->toArray());

        $response->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'referencia_id',
                        'referencia',
                        'pessoa_id',
                        'descricao',
                        'dtVencimentoOriginal',
                        'dtVencimento',
                        'vrBruto',
                        'vrLiquido',
                        'vrDevolvido',
                        'vrPago',
                        'vrTaxa',
                        'vrDesconto',
                        'vrJuros',
                        'user_id',
                        'active',
                        'created_at',
                        'updated_at',
                        'status',
                    ],
                ],
            ],
            'message',
        ])->assertStatus(JsonResponse::HTTP_CREATED);

        $response->assertJson([
            'success' => true,
        ]);

        $responseData = $response->json();
        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $responseData['data']['data'][0]['id']
        ]);
    }

    public function testCrateANewAccountReceivablePayed()
    {
        $accountReceivable = factory(ContaReceber::class)->make();
        $methodOfPayment = factory(FormaPagamento::class)->create(['tipo' => 'dinheiro']);
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();
        $creditCardFlag = factory(BandeiraCartao::class)->create();


        $accountReceivable->vrBruto *= 10;
        $accountReceivable->vrLiquido *= 10;
        $accountReceivable->save();

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamento_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;
        $accountReceivable->status = 'pago';

        $requestData = $accountReceivable->toArray();
        $requestData['bandeira_cartao_id'] = $creditCardFlag->id;
        $requestData['status'] = 'pago';

        $response = $this->postJson(route('receber.store'), $requestData);

        $response->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'referencia_id',
                        'referencia',
                        'pessoa_id',
                        'descricao',
                        'dtVencimentoOriginal',
                        'dtVencimento',
                        'vrBruto',
                        'vrLiquido',
                        'vrDevolvido',
                        'vrPago',
                        'vrTaxa',
                        'vrDesconto',
                        'vrJuros',
                        'user_id',
                        'active',
                        'created_at',
                        'updated_at',
                        'status',
                    ],
                ],
            ],
            'message',
        ])->assertStatus(JsonResponse::HTTP_CREATED);

        $response->assertJson([
            'success' => true,
        ]);

        $responseData = $response->json();
        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $responseData['data']['data'][0]['id'],
            'vrPago' => $accountReceivable->vrBruto,
        ]);
    }

    public function testUpdateAccountReceivable()
    {
        $accountReceivable = factory(ContaReceber::class)->create();
        $accountReceivable->descricao = 'New name';
        $accountReceivable->documento = '123456';

        $response = $this->putJson(route('receber.update', ['id' => $accountReceivable->id]), $accountReceivable->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $accountReceivable->id,
            'descricao' => $accountReceivable->descricao,
            'documento' => $accountReceivable->documento
        ]);
    }

    public function testGetAccountReceivableById()
    {
        $accountReceivable = factory(ContaReceber::class)->create();

        $response = $this->getJson(route('receber.baixar', ['id' => $accountReceivable->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $accountReceivable->id);

        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $accountReceivable->id
        ]);
    }

    public function testPayOffAccountReceivable()
    {
        $accountReceivable = $this->generateAccountReceivable();
        $accountReceivable->save();

        $cash = factory(Caixa::class)->create();

        $response = $this->postJson(route('receber.baixar', [
            'id' => $accountReceivable->id
        ]), [
            'caixa_id' => $cash->id,
            'ds_observacao' => "Test payoff",
            'vr_pago' => $accountReceivable->vrLiquido,
            'vr_final' => $accountReceivable->vrLiquido,
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $accountReceivable->id);

        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $accountReceivable->id,
            'vrPago' => $accountReceivable->vrLiquido
        ]);
    }

    public function generateAccountReceivable()
    {
        $accountReceivable = factory(ContaReceber::class)->make();
        $methodOfPayment = factory(FormaPagamento::class)->create(['tipo' => 'dinheiro']);
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();

        $accountReceivable->vrBruto *= 10;
        $accountReceivable->vrLiquido *= 10;

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamento_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;
        return $accountReceivable;
    }

    public function tearDown(): void
    {
        parent::tearDown();
        //Artisan::call('migrate:rollback');
    }
}
