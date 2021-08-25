<?php

use Illuminate\Database\Seeder;
use App\Estado;
use App\User;
use App\Pais;

class EstadoSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::create(
            [
                'nmEStado'          =>  'Exemplo',
                'codEstado'         =>  '0000',
                'sigla'             =>  'ex',
                'padrao'            =>  'no',
                'pais_id'           =>  Pais::first()->id,
                'user_id'           =>  User::first()->id,
                'user_update_id'    =>  null,
                'active'            =>  'yes',
        
            ]
        );
    }
}
