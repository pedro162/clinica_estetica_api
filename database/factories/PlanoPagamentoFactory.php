<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PlanoPagamento;
use App\User;
use Faker\Generator as Faker;

$factory->define(PlanoPagamento::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word(),
        'descricao' => $faker->unique()->word(),
        'diasmedios' => 5,
        'qtdParcelas' => 5,
        'desdobrarDuplicataManual' => 'no',
        'gerarDuplicataManual' => 'yes',
        'isAtiva' => 'yes',
        'isAberto' => 'yes',
        'user_id' => factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'qtdMinParcelas' => 1,
        'qtd_dias_pri_parcela' => 2,
        'qtdDiasIntervaloParcelas' => 5,
        'exibe_balcao' => 'yes',
    ];
});
