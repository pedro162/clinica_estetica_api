<?php

use App\SimpleTenantDatabase;
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class UsuariosSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* if (! User::where('email', '=', 'admin@gmail.com')->first()) {
            User::create(['name' => 'admin', 'email' => 'admin@gmail.com',  'password' => bcrypt(123456)]);
        }*/

        [$model, $created] = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt(123456),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'tenant_id' => SimpleTenantDatabase::first()->id,
                'active' => 'yes'
            ]
        );
    }
}
