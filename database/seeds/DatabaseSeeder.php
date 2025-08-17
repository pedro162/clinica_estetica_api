<?php

use App\OperadorFinanceiro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(SimpleTenantDatabaseSeeder::class);
        $this->call(UsuariosSeeds::class);
        $this->call(PessoasSeeds::class);
        $this->call(FiliaisSeeds::class);
        $this->call(FormaPagamentosSeeds::class);
        $this->call(GruposSeeds::class);
        $this->call(OperadorFinanceiro::class);
        $this->call(PaisSeeds::class);
        $this->call(EstadoSeeds::class);
    }
}
