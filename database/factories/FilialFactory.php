<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\Pessoa;
use App\User;
use Faker\Generator as Faker;

$factory->define(Filial::class, function (Faker $faker) {
    return [
        'pessoa_id' => factory(Pessoa::class)->create(),
        'dsAtividade' => $faker->unique()->word(),
        'dsTextoContrato' => $faker->unique()->word(),
        'nrExercicioImplantacaoContabil' => null,
        'user_id' => factory(User::class)->create(),
        'user_update_id' => null,
        'active' => 'yes'
    ];
});
