<?php

use Illuminate\Database\Seeder;
use \App\Filial;

class FiliaisSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Filial::create([
            'pessoa_id'                         => \App\Pessoa::first()->id,
            'dsAtividade'                       => 'comercio',
            'dsTextoContrato'                   => 'texto de contrato',
            'nrExercicioImplantacaoContabil'    => '12132',
            'user_id'                           => \App\User::first()->id,
            'active'                            => 'yes'
        ]);
    }
}
