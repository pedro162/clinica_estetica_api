<?php

use Illuminate\Database\Seeder;
use App\Pais;
use App\User;

class PaisSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pais::create(
            [
                'nmPais'=>'Brasil',
                'cdPais'=>'+55',
                'padrao'=>'no',
                'user_id'=>User::first()->id,
                'user_update_id'=>null,
                'active'=>'yes'
            ]
        );
    }
}
