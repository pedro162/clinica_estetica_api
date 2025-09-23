<?php

namespace Database\Seeders;

use App\BandeiraCartao as CreditCardBrand;
use App\SimpleTenantDatabase;
use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditCardBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Visa',
                'standard' => 'no',
                'user_id' => User::first()->id,
                'user_update_id' => User::first()->id,
                'pessoa_autor_id' => User::first()->pessoa->id,
                'active' => 'yes',
                'tenant_id' => SimpleTenantDatabase::first()->id,
            ]
        ];

        foreach ($brands as $brand) {
            CreditCardBrand::updateOrCreate(
                [
                    'name' => $brand['name'],
                    'tenant_id' => $brand['tenant_id'],
                ],
                $brand
            );
        }
    }
}
