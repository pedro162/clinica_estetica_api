<?php

namespace Database\Factories;

use App\Filial;
use App\Pessoa;
use App\Rca;
use App\SimpleTenantDatabase;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Rca>
 */
class RcaFactory extends Factory
{
    protected $model = Rca::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filial = factory(Filial::class)->create();
        $pessoa = factory(Pessoa::class)->create();
        $user = User::first() ? User::first()->id : factory(User::class)->create()->id;
        $tenantId = SimpleTenantDatabase::first() ? SimpleTenantDatabase::first()->id : factory(SimpleTenantDatabase::class)->create()->id;

        return [
            'filial_id' => $filial->id,
            'pessoa_id' => $pessoa->id,
            'acessaTodosRcas' => $this->faker->boolean ? 'yes' : 'no',
            'situacao' => $this->faker->randomElement(['ativo', 'inativo']),
            'metaPositivacao' => $this->faker->randomFloat(2, 0, 100),
            'metaMargem' => $this->faker->randomFloat(2, 0, 100),
            'metaFaturamento' => $this->faker->randomFloat(2, 0, 100000),
            'active' => 'yes',
            'user_id' => $user,
            'user_update_id' => $user,
            'tenant_id' => $tenantId,
        ];
    }
}
