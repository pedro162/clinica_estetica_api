<?php

use App\SimpleTenantDatabase;
use Illuminate\Database\Seeder;

class PessoasSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        [$model, $created] =  \App\Pessoa::updateOrCreate(
            ['name' => 'admin'],
            [
                'name' => 'admin',
                'name_opcional' => 'admin',
                'documento' => '61224450370',
                'email' => 'admin@gmail.com',
                'sexo' => 'm',
                'tipo' => 'fisica',
                'user_id' => \App\User::first()->id,
                'active' => 'yes',
                'tenant_id' => SimpleTenantDatabase::first()->id
            ]
        );

        if ($created) {
            \Illuminate\Support\Facades\Log::info("Pessoa criada.");
        } else {
            \Illuminate\Support\Facades\Log::info("Pessoa atualizada.");
        }
    }
}
