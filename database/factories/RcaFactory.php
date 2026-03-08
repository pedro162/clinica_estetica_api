<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rca;
use App\Pessoa;
use App\Filial;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Rca::class, function (Faker $faker) {
    return [
        'filial_id' => Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
        'pessoa_id' => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create()->id,
        'acessaTodosRcas' => $faker->boolean ? 'yes' : 'no',
        'situacao' => $faker->randomElement(['ativo', 'inativo']),
        'metaPositivacao' => $faker->randomFloat(2, 0, 100),
        'metaMargem' => $faker->randomFloat(2, 0, 100),
        'metaFaturamento' => $faker->randomFloat(2, 0, 100000),
        'active' => 'yes',
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
