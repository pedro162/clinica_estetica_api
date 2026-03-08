<?php

namespace Tests\Feature;

use App\User;

class SetupTest
{
    public function settingUpUser(): void
    {
        if (!User::where('email', '=', 'admin@gmail.com')->first()) {
            User::create(['name' => 'admin', 'email' => 'admin@gmail.com',  'password' => bcrypt(123456)]);
        }
    }
}
