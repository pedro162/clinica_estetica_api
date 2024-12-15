<?php

namespace Tests\Feature\AccountReceivableItem;

use App\ContaReceberItem;
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
        $accountReceivable = factory(ContaReceberItem::class)->make();
        $methodOfPayment = factory(FormaPagamento::class)->create();
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamento_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;

        $this->postJson(route('receber.item.store'), $accountReceivable->toArray())
            ->assertJsonStructure([
                'data',
                'success'
            ])->assertStatus(JsonResponse::HTTP_CREATED);
    }

    public function testCrateANewAccountReceivableItemPayed()
    {
        $accountReceivable = factory(ContaReceberItem::class)->make();
        $methodOfPayment = factory(FormaPagamento::class)->create();
        $paymentPlanObject = factory(PlanoPagamento::class)->create();
        $financialOperator = factory(OperadorFinanceiro::class)->create();

        $methodOfPayment->planoPagamento()->attach($paymentPlanObject->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);
        $methodOfPayment->operadorFinanceiro()->attach($financialOperator->id, ['user_id' => factory(User::class)->create()->id, 'active' => 'yes']);

        $accountReceivable->forma_pagamento_id = $methodOfPayment->id;
        $accountReceivable->plano_pagamento_id = $paymentPlanObject->id;
        $accountReceivable->operador_financeiro_id = $financialOperator->id;
        $accountReceivable->status = 'pago';

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

    public function tearDown(): void
    {
        parent::tearDown();
        //Artisan::call('migrate:rollback');
    }
}
