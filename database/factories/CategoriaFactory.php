<?php

use App\Categoria;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(Categoria::class, function (Faker $faker) {
    return [
        'name'      => $faker->word,
        'user_id'   => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
        'active'    => 'yes',
    ];
});
