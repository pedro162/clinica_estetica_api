<?php

use Illuminate\Database\Seeder;
use \App\FormaPagamento;
use \App\User;

class FormaPagamentosSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormaPagamento::create([
        	'name'=>'din',
			'cdCobrancaTipo'=>'din',
			'hasComissao'=>'yes',
			'tpPagamento'=>'a vista',
			'hasDesdobramento'=>'yes',
			'hasLimiteDeCredito'=>'no',
			'hasAcertoBalcao'=>'no',
			'hasAcertoCaixa'=>'no',
			'hasEntrada'=>'yes',
			'user_id'=>User::first()->id ?? 1,
			'active'=>'yes'
        ]);
    }
}
