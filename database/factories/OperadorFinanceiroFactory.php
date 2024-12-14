<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Filial;
use App\OperadorFinanceiro;
use App\Pessoa;
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
        'pessoa_id' => factory(Pessoa::class)->create()->id,
        'filial_id' => factory(Filial::class)->create()->id,
        'user_id' => factory(User::class)->create()->id,
        'user_update_id' => null,
        'active' => 'yes'
    ];
});
