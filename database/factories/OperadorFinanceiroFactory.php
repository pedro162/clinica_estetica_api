<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\OperadorFinanceiro;
use App\Pessoa;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(OperadorFinanceiro::class, function (Faker $faker) {
    return [
        'vrTarifa' => 0,
        'vrDesconto' => 0,
        'vrPorcentagemDesconto' => 0,
        'nrRemessaAtual' => 0,
        'nrNossoNumero' => 0,
        'qtdDiasProtesto' => 0,
        'isAssumeDuplicata' => 'no',
        'tpLocalAtualizacaoBoleto' => 'empresa',
        'isPadrao' => 'yes',
        'isLiberado' => 'yes',
        'pessoa_id' => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create()->id,
        'filial_id' => Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
