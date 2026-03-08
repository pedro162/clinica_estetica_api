<?php

use App\OrdemServico;
use App\Pessoa;
use App\Rca;
use App\Filial;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

$factory->define(OrdemServico::class, function (Faker $faker) {
    return [
        'vrTotal'        => $faker->randomFloat(2, 50, 1000),
        'status'         => $faker->randomElement(['aberto', 'cancelado', 'aguardando', 'concluido']),
        'observacao'     => $faker->sentence,
        'dsArquivo'      => null,
        'pessoa_id'      => Pessoa::first() ? Pessoa::first()->id : factory(Pessoa::class)->create()->id,
        'pessoa_rca_id'  => Rca::first() ? Rca::first()->id : factory(Rca::class)->create()->id,
        'filial_id'      => Filial::first() ? Filial::first()->id : factory(Filial::class)->create()->id,
        'user_id'        => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'active'         => 'yes',
        'vr_final'       => $faker->randomFloat(2, 50, 1000),
        'vr_desconto'    => $faker->randomFloat(2, 0, 200),
        'pct_acrescimo'  => $faker->randomFloat(2, 0, 20),
        'vr_acrescimo'   => $faker->randomFloat(2, 0, 200),
        'pct_desconto'   => $faker->randomFloat(2, 0, 50),
        'is_faturado'    => $faker->boolean ? 'yes' : 'no',
        'td_faturamento' => null,
        'td_cancelamento' => null,
        'td_conclusao'   => null,
        'pess_fat_id'    => null,
        'pess_cancel_id' => null,
        'pess_concl_id'  => null,
        'profissional_id' => null,
        'mt_calcel_id'   => null,
        'type'           => $faker->randomElement(['orcamento', 'pedido']),
        'is_orcamento'   => $faker->boolean ? 'yes' : 'no',
        'tenant_id'      => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
