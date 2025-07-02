<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Grupo;
use App\Pessoa;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Grupo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'descricao' => $faker->name,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create(),
        'user_update_id' => null,
        'active' => $faker->randomElement(['yes', 'no']),
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
