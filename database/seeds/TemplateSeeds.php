<?php

use App\Template;
use App\User;
use Illuminate\Database\Seeder;

class TemplateSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::create([
            'body' => '',
            'language' => 'en_US',
            'title' => 'Default',
            'user_id' => User::where('id', '>', 0)->first()->id,
            'user_update_id' => null,
            'active' => 'yes',
        ]);
    }
}
