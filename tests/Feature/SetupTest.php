<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Artisan;

class SetupTest
{
    public function settingUpUser(): void
    {
        if (!User::where('email', '=', 'admin@gmail.com')->first()) {
            User::create(['name' => 'admin', 'email' => 'admin@gmail.com',  'password' => bcrypt(123456)]);
        }
    }
}
