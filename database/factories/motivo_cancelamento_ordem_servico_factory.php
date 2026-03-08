<?php

use App\MotivoCancelamentoOrdemServico;
use App\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(
    MotivoCancelamentoOrdemServico::class,
    function (Faker $faker) {
        $user = User::first() ?: factory(User::class)->create();

        return [
            'motivo'  => $faker->sentence,
            'user_id' => $user->id,
            'active'  => 'yes',
        ];
    }
);
