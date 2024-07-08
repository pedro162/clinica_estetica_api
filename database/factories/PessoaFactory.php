<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pessoa as Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    //Factory States
    //Documentation->https://laravel.com/docs/11.x/eloquent-factories#main-content
    return [
        'name' => $faker->name,
        'name_opcional' => $faker->name,
        'documento' => $faker->str,
        'documento_complementar',
        'email',
        'nascimento_fundacao',
        'sexo',
        'tipo',
        'user_id',
        'user_update_id',
        'active'
    ];
});
