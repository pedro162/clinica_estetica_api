<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\Pessoa;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(SimpleTenantDatabase::class, function (Faker $faker) {
    //Factory States
    //Documentation->https://laravel.com/docs/11.x/eloquent-factories#main-content
    return [
        'name' => $faker->name,
        'contact_number' => null,
        'contact_email' => null,
        'document' => null,
        'max_users' => rand(1, 10),
        'account_status' => $faker->randomElement(['activated', 'canceled', 'paused']),
        'active' => 'yes',
    ];
});
