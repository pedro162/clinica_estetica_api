<?php

use Illuminate\Database\Seeder;
use App\Logradouro;

class LogradourosSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Logradouro::create([
	    	'cep' => '65061220',
			'cidade' => 'Bacuri',
			'logradouro' => 'Rua nova',
			'complemento' => 'Proximo ao bar',
			'numero' => 2,
			'bloco' => 2,
			'tipo' => 'casa',
			'importancia' => 'principal',
			'user_id' => 1,
			//'user_update_id',
			'active' => 'yes',
			'bairro' => 'Piquizeiro',
			'estado' => 'MA'
	    ]);
    }
}
