<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContaReceber;
use App\Filial;
use App\FormaPagamento;
use App\OperadorFinanceiro;
use App\Pessoa;
use App\PlanoPagamento;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(ContaReceber::class, function (Faker $faker) {
    return [
        'referencia_id' => $faker->numberBetween(1, 10),
        'referencia' => $faker->unique()->word(),
        'pessoa_id' => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create()->id,
        'descricao' => $faker->unique()->word(),
        'documento' => $faker->unique()->word(),
        'dtVencimentoOriginal' => $faker->date(),
        'dtVencimento' => $faker->date(),
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
        'responsavel_id' => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create()->id,
        'importacao_dados' => 'no',
        'filial_id' => Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
        'forma_pagamento_id' => FormaPagamento::first() ? Filial::first()->id : factory(FormaPagamento::class)->create()->id,
        'plano_pagamento_id' => PlanoPagamento::first() ? Filial::first()->id : factory(PlanoPagamento::class)->create()->id,
        'operador_financeiro_id' => OperadorFinanceiro::first() ? Filial::first()->id : factory(OperadorFinanceiro::class)->create()->id,
        'status' => 'aberto',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
