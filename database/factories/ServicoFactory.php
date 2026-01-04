<?php

namespace Database\Factories;

use App\Servico;
use App\SimpleTenantDatabase;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\=Servico>
 */
class ServicoFactory extends Factory
{
    protected $model = Servico::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'vrServico' => $this->faker->randomFloat(2, 10, 1000),
            'unidade' => $this->faker->word(),
            'type' => $this->faker->randomElement(['mensalidade', 'outros']),
            'user_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
            'user_update_id' => User::first() ? User::first()->id : factory(User::class)->create()->id,
            'active' => 'yes',
            'tenant_id' => SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id,
        ];
    }
}
