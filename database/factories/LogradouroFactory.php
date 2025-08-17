<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Estado;
use App\Logradouro as Address;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'cep' => '11111111',
        'cidade' => $faker->city,
        'logradouro' => $faker->streetName,
        'complemento' => $faker->secondaryAddress,
        'numero' => $faker->buildingNumber,
        'bloco' => $faker->bothify('Bloco ##'),
        'tipo' =>  $faker->randomElement(['casa', 'apartamento']),
        'importancia' => $faker->randomElement(['principal', 'secundario']),
        'bairro' => $faker->streetName,
        'estado' => Estado::first() ? Estado::first()->id : factory(Estado::class)->create()->id,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
