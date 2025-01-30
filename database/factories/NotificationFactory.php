<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\Pessoa;
use App\Notification;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Notification::class, function (Faker $faker) {
    //Factory States
    //Documentation->https://laravel.com/docs/11.x/eloquent-factories#main-content
    return [
        'title' => $faker->name,
        'message' => Str::random(10),
        'origin_contact_address' => $faker->email,
        'target_contact_address' => $faker->email,
        'target_contact_name' => $faker->name,
        'template_id' => 0,
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
        'shipping_state' => 'waiting',
        'sent_date' => null,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'type' => $faker->randomElement(['email', 'whatsapp', 'default']),
        'filial_id' =>  Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
    ];
});
