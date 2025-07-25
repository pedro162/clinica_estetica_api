<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Telefone;
use App\Pessoa;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Telefone::class, function (Faker $faker) {
    return [
        'numero' => $faker->phoneNumber,
        'tipo' => $faker->randomElement(['celular', 'fixo']),
        'whatsapp' => $faker->randomElement(['sim', 'nao']),
        'pessoa_id' => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create(),
        'importancia' => $faker->randomElement(['principal', 'secundario']),
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create(),
        'user_update_id' => null,
        'active' => $faker->randomElement(['yes', 'no']),
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
