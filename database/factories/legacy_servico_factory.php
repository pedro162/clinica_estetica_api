<?php

use App\Servico;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(
    Servico::class,
    function (Faker $faker) {
        $user = User::first() ?: factory(User::class)->create();
        $tenant = SimpleTenantDatabase::first() ?: factory(SimpleTenantDatabase::class)->create();

        return [
            'name' => $faker->word,
            'descricao' => $faker->sentence,
            'vrServico' => $faker->randomFloat(2, 10, 1000),
            'unidade' => $faker->word,
            'type' => $faker->randomElement(['mensalidade', 'outros']),
            'user_id' => $user->id,
            'user_update_id' => $user->id,
            'active' => 'yes',
            'tenant_id' => $tenant->id,
        ];
    }
);
