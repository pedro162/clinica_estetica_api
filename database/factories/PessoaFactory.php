<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pessoa as Person;
use App\SimpleTenantDatabase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Person::class, function (Faker $faker) {
    //Factory States
    //Documentation->https://laravel.com/docs/11.x/eloquent-factories#main-content
    $type = $faker->randomElement(['fisica', 'juridica']);
    $document = $faker->randomElement(['80638838029', '54617916032']);
    $extraDocument = $faker->randomElement(['8063883802', '5461791603']);

    //$document = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);

    if ($type == 'juridica') {
        $document = $faker->randomElement(['31356555000102', '90517181000110']);
        $extraDocument = $faker->randomElement(['3135655500', '9051718100']);
        //$document = str_pad(mt_rand(0, 99999999999), 14, '0', STR_PAD_LEFT);
    }

    return [
        'name' => $faker->name,
        'name_opcional' => $faker->name,
        'documento' => $document,
        'documento_complementar' => $extraDocument,
        'email' => $faker->unique()->safeEmail,
        'nascimento_fundacao' => substr(now()->subYears(26), 0, 10),
        'sexo' => $faker->randomElement(['m', 'f']),
        'tipo' => $type,
        'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
        'active' => 'yes',
        'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
    ];
});
