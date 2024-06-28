<?php

use App\Template;
use App\TemplateVariable;
use App\User;
use Illuminate\Database\Seeder;

class TemplateVariableSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 9; $i++) {
            TemplateVariable::create([
                'syntax' => '{{' . $i . '}}',
                'value' => '',
                'template_id' => Template::where('id', '>', 0)->first()->id,
                'user_id' => User::where('id', '>', 0)->first()->id,
                'user_update_id' => null,
                'active' => 'yes',
            ]);
        }
    }
}
