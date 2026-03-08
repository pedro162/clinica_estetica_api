<?php

use App\OrdemServico;
use App\Servico;
use App\ServicoItem;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(
    ServicoItem::class,
    function (Faker $faker) {
        $order   = OrdemServico::first() ?: factory(OrdemServico::class)->create();
        $service = Servico::first() ?: factory(Servico::class)->create();
        $user    = User::first() ?: factory(User::class)->create();

        $quantity   = 1;
        $totalValue = $faker->randomFloat(2, 50, 500);
        $discount   = $faker->randomFloat(2, 0, $totalValue);
        $finalValue = $totalValue - $discount;

        return [
            'ordem_servico_id' => $order->id,
            'servico_id'       => $service->id,
            'qtd'              => $quantity,
            'vrItem'           => $totalValue,
            'vrTotal'          => $totalValue,
            'vr_desconto'      => $discount,
            'vr_final'         => $finalValue,
            'user_id'          => $user->id,
            'active'           => 'yes',
            'tenant_id'      => SimpleTenantDatabase::first()
                ? SimpleTenantDatabase::first()->id
                : factory(SimpleTenantDatabase::class)->create()->id,
        ];
    }
);
