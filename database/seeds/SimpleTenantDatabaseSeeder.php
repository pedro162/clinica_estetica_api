<?php

use Illuminate\Database\Seeder;
use \App\SimpleTenantDatabase;
use Illuminate\Support\Facades\Log;

class SimpleTenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        [$model, $created] = SimpleTenantDatabase::updateOrCreate(
            ['name' => 'default'],
            [
                'contact_number' => null,
                'contact_email' => null,
                'document' => null,
                'max_users' => 10,
                'account_status' => 'activated',
                'active' => 'yes',
            ]
        );

        if ($created) {
            Log::info("Registro criado.");
        } else {
            Log::info("Registro atualizado.");
        }
    }
}
