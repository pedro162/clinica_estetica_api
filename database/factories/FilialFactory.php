<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\Pessoa;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Filial::class, function (Faker $faker) {
    return [
        'pessoa_id' => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create(),
        'dsAtividade' => $faker->unique()->word(),
        'dsTextoContrato' => $faker->unique()->word(),
        'nrExercicioImplantacaoContabil' => null,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create(),
        'user_update_id' => null,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
