<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Configura o Redis usado pelo Prometheus
        Redis::setDefaultOptions([
            'host' => env('REDIS_HOST', 'redis'),
            'port' => env('REDIS_PORT', 6379),
            'password' => env('REDIS_PASSWORD', null),
            'timeout' => 0.1,
            'read_timeout' => 10,
            'persistent_connections' => false,
        ]);

        // Singleton
        $this->app->singleton(CollectorRegistry::class, function () {
            $registry = new CollectorRegistry(new Redis());

            // Cria a métrica customizada de boot timestamp
            $bootGauge = $registry->getOrRegisterGauge(
                'laravel',                     // namespace
                'laravel_boot_timestamp',      // nome da métrica
                'Timestamp of Laravel application boot' // descrição
            );

            $bootGauge->set(time()); // registra o timestamp atual

            return $registry;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
