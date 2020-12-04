<?php

use Illuminate\Database\Seeder;
use \App\OperadorFinanceiro;
use \App\Filial;
use \App\User;
use \App\Pessoa;

class OperadorFinanceirosSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OperadorFinanceiro::create([
	    	'vrTarifa' 					=> 20,
			'vrDesconto' 				=> 0,
			'vrPorcentagemDesconto' 	=> 2,
			'nrRemessaAtual' 			=> 1,
			'nrNossoNumero' 			=> 3,
			'qtdDiasProtesto' 			=> 4,
			'isAssumeDuplicata' 		=> 'no',
			'tpLocalAtualizacaoBoleto' 	=> 'empresa',
			'isPadrao' 					=> 'yes',
			'isLiberado' 				=> 'yes',
			'pessoa_id' 				=> Pessoa::first()->id,
			'filial_id' 				=> Filial::first()->id,
			'user_id' 					=> User::first()->id,
			//'user_update_id' 			=> 1,
			'active' 					=> 'yes'
	    ]);
    }
}
