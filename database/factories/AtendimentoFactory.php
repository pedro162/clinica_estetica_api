<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Atendimento;
use App\Pessoa;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Atendimento::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'historico' => Str::random(50),
        'pessoa_id' => $faker->name,
        'user_id' => User::factory(),
        'user_update_id' => null,
        'active' => 'yes',
        'profissional_id' => null,
        'prioridade' => 'normal',
        'status' => null,
        'dt_fim' => date('Y-d-d'),
        'hr_fim' => date('H:i:s'),
        'name_atendido' => $faker->name,
        'tipo' => null,
        'dt_inicio' => null,
        'hr_inicio' => null,
        'filial_id' => null,
        'dt_cancelamento' => null,
        'ds_cancelamento' => null,
        'pess_cancel_id' => null,
        'vr_atendimento' => null,
        'vr_desconto' => null,
        'vr_acrescimo' => null,
    ];
});
