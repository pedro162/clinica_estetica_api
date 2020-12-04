<?php

use Illuminate\Database\Seeder;
use \App\PlanoPagamento;
use \App\User;

class PlanoPagamentosSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanoPagamento::create([
        	'name' 						=> 'à vista',
			'descricao' 				=> 'venda a vista',
			'diasmedios' 				=> '0',
			'qtdParcelas' 				=> 1,
			'desdobrarDuplicataManual' 	=> 'no',
			'gerarDuplicataManual' 		=> 'yes',
			'isAtiva' 					=> 'yes',
			'isAberto' 					=> 'yes',
			'user_id' 					=> User::first()->id,
			//'user_update_id' 			=> 'à vista',
			'active' 					=> 'yes'
        ]);
    }
}
