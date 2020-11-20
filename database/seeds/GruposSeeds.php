<?php

use Illuminate\Database\Seeder;
use \App\Grupo;
use \App\User;

class GruposSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create(
        	['name'=>'Clientes',
			'descricao'=>'Clientes da Empresa',
			'user_id'=>User::first()->id,
			'active'=>'yes'
			]);
    }
}
