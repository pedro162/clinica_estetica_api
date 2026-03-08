<?php

use App\FormaPagamento;
use App\OperadorFinanceiro;
use App\OrdemServico;
use App\OrdemServicoCobranca;
use App\PlanoPagamento;
use App\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(
    OrdemServicoCobranca::class,
    function (Faker $faker) {
        $order    = OrdemServico::first() ?: factory(OrdemServico::class)->create();
        $user     = User::first() ?: factory(User::class)->create();
        $operator = OperadorFinanceiro::first() ?: factory(OperadorFinanceiro::class)->create();
        $payment  = FormaPagamento::first() ?: factory(FormaPagamento::class)->create([
            'hasOperadorFinanceiro' => 'yes',
        ]);
        $plan     = PlanoPagamento::first() ?: factory(PlanoPagamento::class)->create();

        $finalValue = 100.0;

        return [
            'ordem_servico_id'       => $order->id,
            'filial_id'              => $order->filial_id,
            'forma_pagamento_id'     => $payment->id,
            'plano_pagamento_id'     => $plan->id,
            'operador_financeiro_id' => $operator->id,
            'vr_final'               => $finalValue,
            'nr_doc'                 => (string) $faker->randomNumber(),
            'user_id'                => $user->id,
            'active'                 => 'yes',
        ];
    }
);
