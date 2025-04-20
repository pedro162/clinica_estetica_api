<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Caixa;
use App\ContaReceber;
use App\ContaReceberItem;
use App\Filial;
use App\FormaPagamento;
use App\OperadorFinanceiro;
use App\Pessoa;
use App\PlanoPagamento;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(ContaReceberItem::class, function (Faker $faker) {
    return [
        'dtPagamento' => null,
        'dtBaixa' => null,
        'ds_estorno' => null,
        'descricao' => $faker->unique()->word(),
        'documento' => $faker->unique()->word(),
        'vrBruto' => $grossValue = $faker->numberBetween(10, 9561),
        'vrLiquido' => $grossValue,
        'vrDevolvido' => 0,
        'vrPago' => 0,
        'vrTaxa' => 0,
        'vrDesconto' => 0,
        'vrJuros' => 0,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'forma_pagamentos_id' => FormaPagamento::first() ? FormaPagamento::first()->id :  factory(FormaPagamento::class)->create()->id,
        'plano_pagamento_id' => PlanoPagamento::first() ? PlanoPagamento::first()->id :  factory(PlanoPagamento::class)->create()->id,
        'operador_financeiro_id' => OperadorFinanceiro::first() ? OperadorFinanceiro::first()->id :  factory(OperadorFinanceiro::class)->create()->id,
        'conta_receber_id' => factory(ContaReceber::class)->create()->id,
        'caixa_id' => Caixa::first() ? Caixa::first()->id : factory(Caixa::class)->create()->id,
        'pessoa_estorno_id' => null,
        'pessoa_baixa_id' => null,
        'pessoa_devolucao_id' => null,
        'tpBaixa' => 'user',
        'rashBaixa' => null,
        'status' => 'aberto',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
