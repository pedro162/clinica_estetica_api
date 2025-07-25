<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pais;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Pais::class, function (Faker $faker) {
    return [
        'nmPais' => $faker->country,
        'cdPais' => $faker->countryCode,
        'padrao' => $faker->randomElement(['yes', 'no']),
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => $faker->randomElement(['yes', 'no']),
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
