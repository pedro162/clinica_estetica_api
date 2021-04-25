<?php

use Illuminate\Database\Seeder;
use App\User;

class UsuariosSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(! User::where('email', '=', 'admin@gmail.com')->first()){
        	User::create(['name'=>'admin','email'=>'admin@gmail.com',  'password'=>bcrypt(123456)]);
		}
    }
}