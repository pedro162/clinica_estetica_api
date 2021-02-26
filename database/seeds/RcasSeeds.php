<?php

use Illuminate\Database\Seeder;
use App\Rca;

class RcasSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rca::create([
            'filial_id',
            'pessoa_id',
            'acessaTodosRcas',
            'situacao',
            'metaPositivacao',
            'metaMargem',
            'metaFaturamento',
            'active',
            'user_id',
            'user_update_id',
        ]);
    }
}
