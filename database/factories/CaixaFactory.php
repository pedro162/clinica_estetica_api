<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Caixa;
use App\Filial;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Caixa::class, function (Faker $faker) {
    $data = [
        'name' => $faker->unique()->word(),
        'type' => 'convencional',
        'vrMin' => $faker->numberBetween(0, 500),
        'vrMax' => $faker->numberBetween(500, 5000),
        'vrSaldo' => 0,
        'tpSaldo' => 'positivo',
        'status_abertura' => 'open',
        'status_bloqueio' => 'liberado',
        'aceita_transferencia' => 'yes',
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'filial_id' => Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];

    return $data;
});
