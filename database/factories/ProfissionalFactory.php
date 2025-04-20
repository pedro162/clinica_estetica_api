<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\Pessoa;
use App\Profissional as Professional;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Professional::class, function (Faker $faker) {
    //Factory States
    //Documentation->https://laravel.com/docs/11.x/eloquent-factories#main-content
    return [
        'pessoa_id' => factory(Pessoa::class)->create(),
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'vr_salario' => $faker->numberBetween(10, 6000),
        'titulo_eleitor' => null,
        'zona_eleitor' => null,
        'naturalidade' => null,
        'name_mae' => null,
        'name_conjuge' => null,
        'nr_serie_cnh' => null,
        'name_banco_salario' => null,
        'nr_agencia_banco_salario' => null,
        'nr_conta_banco_salario' => null,
        'ponto_obrigatorio' => 'no',
        'estado_civil' => 'solteiro',
        'grau_instrucao' => 'fundamental',
        'status' => 'admitido',
        'tipo_contrato' => 'efetivo',
        'filial_id' => Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
        'uf_cnh_id' => null,
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
