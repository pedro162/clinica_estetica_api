<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            $connectionName = $query->connectionName; // ex: mysql
            $config = $query->connection->getConfig();

            $type = $query->connection->transactionLevel() ? 'write (transaction)' : ($config['read'] ?? false ? 'read' : 'write');

            $host = $config['host'] ?? 'unknown';

            Log::info("Query executada na conexão: {$connectionName}, tipo: {$type}, host: {$host}", [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ]);
        });


        Model::unguard(); // opcional
        Schema::defaultStringLength(191);

        // Para manter o namespace antigo
        Model::preventLazyLoading(!app()->isProduction());
    }
}
