<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Estado;
use App\Pais;
use App\User;
use Faker\Generator as Faker;

$factory->define(Estado::class, function (Faker $faker) {
    return [
        'nmEStado' => $faker->name,
        'codEstado' => '1235',
        'sigla' => $faker->slug(),
        'padrao' => 'no',
        'pais_id' => factory(Pais::class)->create()->id,
        'user_id' => factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
    ];
});
