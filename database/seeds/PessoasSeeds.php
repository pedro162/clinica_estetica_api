<?php

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
        \App\Pessoa::create(
            ['name'=>'pedro', 'name_opcional'=>'aguiar',
             'documento'=>'61224450370',
             'email'=>'pedroclooney@gmail.com', 'sexo'=>'m',
             'tipo'=>'fisica', 'user_id'=>\App\User::first()->id, 'active'=>'yes']
            );

    }
}
