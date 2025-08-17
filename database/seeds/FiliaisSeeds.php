<?php

use Illuminate\Database\Seeder;
use \App\Filial;
use App\SimpleTenantDatabase;

class FiliaisSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        [$model, $created] =  \App\Filial::updateOrCreate(
            ['pessoa_id' => \App\Pessoa::first()->id],
            [
                'dsAtividade'                       => 'comercio',
                'dsTextoContrato'                   => 'texto de contrato',
                'nrExercicioImplantacaoContabil'    => '12132',
                'user_id'                           => \App\User::first()->id,
                'active'                            => 'yes',
                'tenant_id' => SimpleTenantDatabase::first()->id
            ]
        );

        if ($created) {
            \Illuminate\Support\Facades\Log::info("Filial criada.");
        } else {
            \Illuminate\Support\Facades\Log::info("Filial atualizada.");
        }
    }
}
