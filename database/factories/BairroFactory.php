<?php

use App\Bairro;
use App\Cidade;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Bairro::class, function (Faker $faker) {
    return [
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'name' => $faker->streetName(),
        'codIbge' => (string) $faker->randomNumber(5),
        'cep' => $faker->postcode(),
        'cidade_id' => Cidade::first() ? Cidade::first()->id : factory(Cidade::class)->create()->id,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
