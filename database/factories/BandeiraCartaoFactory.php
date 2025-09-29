<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BandeiraCartao;
use App\Pessoa;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(BandeiraCartao::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word(),
        'standard' => 'no',
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        //'pessoa_autor_id' => factory(Pessoa::class)->create()->id,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
