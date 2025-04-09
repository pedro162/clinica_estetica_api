<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FormaPagamento;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(FormaPagamento::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word(),
        'cdCobrancaTipo' => Str::random(3),
        'hasComissao' => 'no',
        'tpPagamento' => 'a vista',
        'hasDesdobramento' => 'no',
        'hasLimiteDeCredito' => 'no',
        'hasAcertoBalcao' => 'no',
        'hasAcertoCaixa' => 'no',
        'hasEntrada' => 'no',
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'hasOperadorFinanceiro' => 'no',
        'tipo' => 'cartao_credito',
        'active' => 'yes'
    ];
});
