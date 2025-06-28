<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cidade;
use App\Estado;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Cidade::class, function (Faker $faker) {
    return [
        'nmCidade' => $faker->city,
        'sigla' => $faker->citySuffix,
        'cdCidade' => '12',
        'estado_id' => factory(Estado::class)->create()->id,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
        //'tenant_id' => null
    ];
});
