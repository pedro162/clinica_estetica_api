<?php

namespace App\Providers\Service;

use App\Application\Services\Service\ServiceApplicationService;
use App\Application\Services\Service\ServiceApplicationServiceInterface;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Service\ServiceRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ServiceApplicationServiceInterface::class, ServiceApplicationService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
