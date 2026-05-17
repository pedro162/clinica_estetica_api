<?php

namespace Tests\Feature\AccountReceivableItem;

use App\Caixa;
use App\ContaReceber;
use App\ContaReceberItem;
use App\FinanceiroMovimentacoe;
use App\FormaPagamento;
use App\OperadorFinanceiro;
use App\PlanoPagamento;
use App\User;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AccountReceivableItemTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        //Artisan::call('migrate:refresh --force');
        //Artisan::call('migrate');

        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    public function testGetAllAccountReceivableItems()
    {
        $response = $this->getJson(route('receber.item.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ]);
    }

    public function testCrateANewAccountReceivableItem()
    {
        $accountReceivable = factory(ContaReceberItem::class)->make(['vrPago' => 0, 'documento' => '', 'caixa_id' => null]);
        $methodOfPayment = factory(FormaPagamento::class)->create(['tipo' => 'dinheiro']);
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();

        $accountReceivable->contaReceber->vrBruto *= 10;
        $accountReceivable->contaReceber->vrLiquido *= 10;
        $accountReceivable->contaReceber->save();

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamentos_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;
        $accountReceivable->status = 'aberto';

        $response = $this->postJson(route('receber.item.store'), $accountReceivable->toArray());

        $response->assertJsonStructure([
            'data',
            'success'
        ])->assertStatus(JsonResponse::HTTP_CREATED);

        $response->assertJson([
            'success' => true,
        ]);
    }

    public function testCrateANewAccountReceivableItemPayed()
    {
        $accountReceivable = factory(ContaReceberItem::class)->make(['vrPago' => 1, 'documento' => '', 'caixa_id' => null]);
        $methodOfPayment = factory(FormaPagamento::class)->create(['tipo' => 'dinheiro']);
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();
        $accountReceivable->contaReceber->vrBruto *= 10;
        $accountReceivable->contaReceber->vrLiquido *= 10;
        $accountReceivable->contaReceber->save();

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamentos_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;
        $accountReceivable->status = 'aberto';

        $this->postJson(route('receber.item.store'), $accountReceivable->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertStatus(JsonResponse::HTTP_CREATED);
    }

    public function testUpdateAAccountReceivableItem()
    {
        $accountReceivable = factory(ContaReceberItem::class)->create();
        $accountReceivable->descricao = 'New name';
        $accountReceivable->documento = '123456';
        $response = $this->putJson(route('receber.item.update', ['id' => $accountReceivable->id]), $accountReceivable->toArray())
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $accountReceivable->id,
            'descricao' => $accountReceivable->descricao,
            'documento' => $accountReceivable->documento
        ]);
    }

    public function testGetAAccountReceivableItemById()
    {
        $accountReceivable = factory(ContaReceberItem::class)->create();

        $response = $this->getJson(route('receber.item.show', ['id' => $accountReceivable->id]));

        $response->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertJsonPath('data.id', $accountReceivable->id);

        $this->assertDatabaseHas($accountReceivable->getTable(), [
            'id' => $accountReceivable->id
        ]);
    }

    public function testReverseAccountReceivableItem()
    {
        $operationHash = 'hash-estorno-teste-' . uniqid();
        $cash = factory(Caixa::class)->create();
        $methodOfPayment = factory(FormaPagamento::class)->create(['tipo' => 'dinheiro']);
        $paymentPlan = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();

        $accountReceivable = factory(ContaReceber::class)->create([
            'vrBruto' => 150,
            'vrLiquido' => 150,
            'vrPago' => 150,
            'status' => 'pago',
            'forma_pagamento_id' => $methodOfPayment->id,
            'plano_pagamento_id' => $paymentPlan->id,
            'operador_financeiro_id' => $financialOperator->id,
        ]);

        $accountReceivableItem = ContaReceberItem::create([
            'conta_receber_id' => $accountReceivable->id,
            'caixa_id' => $cash->id,
            'status' => 'pago',
            'descricao' => 'Item de estorno teste',
            'documento' => 'EST-001',
            'vrBruto' => 150,
            'vrLiquido' => 150,
            'vrPago' => 150,
            'vrDevolvido' => 0,
            'vrTaxa' => 0,
            'vrDesconto' => 0,
            'vrJuros' => 0,
            'forma_pagamentos_id' => $methodOfPayment->id,
            'plano_pagamento_id' => $paymentPlan->id,
            'operador_financeiro_id' => $financialOperator->id,
            'user_id' => User::first()->id,
            'active' => 'yes',
            'tpBaixa' => 'user',
            'rashBaixa' => $operationHash,
            'tenant_id' => $accountReceivable->tenant_id,
        ]);

        FinanceiroMovimentacoe::insert([
            [
                'referencia_id' => $accountReceivable->id,
                'referencia' => 'conta_recebers',
                'sub_referencia_id' => $accountReceivableItem->id,
                'sub_referencia' => 'conta_receber_items',
                'historico' => 'Recebimento principal',
                'caixa_id' => $cash->id,
                'vr_saldo_anterior' => 0,
                'vr_movimentacao' => 100,
                'vr_saldo' => 100,
                'tp_movimentacao' => 'positiva',
                'conciliado' => 'no',
                'estornado' => 'no',
                'hash_operacao' => $operationHash,
                'user_id' => User::first()->id,
                'active' => 'yes',
                'tenant_id' => $accountReceivableItem->tenant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'referencia_id' => $accountReceivable->id,
                'referencia' => 'conta_recebers',
                'sub_referencia_id' => $accountReceivableItem->id,
                'sub_referencia' => 'conta_receber_items',
                'historico' => 'Recebimento taxa',
                'caixa_id' => $cash->id,
                'vr_saldo_anterior' => 100,
                'vr_movimentacao' => 50,
                'vr_saldo' => 150,
                'tp_movimentacao' => 'positiva',
                'conciliado' => 'no',
                'estornado' => 'no',
                'hash_operacao' => $operationHash,
                'user_id' => User::first()->id,
                'active' => 'yes',
                'tenant_id' => $accountReceivableItem->tenant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->putJson(route('receber.item.estornar', ['id' => $accountReceivableItem->id]), [
            'caixa_id' => $cash->id,
            'descricao' => 'Estorno teste',
        ])->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseHas('conta_receber_items', [
            'id' => $accountReceivableItem->id,
            'status' => 'aberto',
            'vrPago' => 0,
        ]);

        $this->assertDatabaseHas('conta_recebers', [
            'id' => $accountReceivable->id,
            'status' => 'aberto',
            'vrPago' => 0,
        ]);

        $this->assertEquals(
            4,
            FinanceiroMovimentacoe::where('hash_operacao', $operationHash)->count()
        );

        $this->assertEquals(
            2,
            FinanceiroMovimentacoe::where('hash_operacao', $operationHash)
                ->where('estornado', 'yes')
                ->where('tp_movimentacao', 'positiva')
                ->count()
        );

        $this->assertEquals(
            2,
            FinanceiroMovimentacoe::where('hash_operacao', $operationHash)
                ->where('tp_movimentacao', 'negativa')
                ->whereIn('vr_movimentacao', [-100, -50])
                ->count()
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        //Artisan::call('migrate:rollback');
    }
}
