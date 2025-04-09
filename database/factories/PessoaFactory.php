<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pessoa as Person;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Person::class, function (Faker $faker) {
    //Factory States
    //Documentation->https://laravel.com/docs/11.x/eloquent-factories#main-content
    return [
        'name' => $faker->name,
        'name_opcional' => $faker->name,
        'documento' => Str::random(10),
        'documento_complementar' => Str::random(10),
        'email' => $faker->unique()->safeEmail,
        'nascimento_fundacao' => substr(now()->subYears(26), 0, 10),
        'sexo' => 'm',
        'tipo' => 'fisica',
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes'
    ];
});
