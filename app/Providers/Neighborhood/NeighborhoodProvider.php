<?php

namespace App\Providers\Neighborhood;

use App\Application\Services\Neighborhood\NeighborhoodApplicationService;
use App\Application\Services\Neighborhood\NeighborhoodApplicationServiceInterface;
use App\Domain\Neighborhood\Repositories\NeighborhoodRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Neighborhood\NeighborhoodRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class NeighborhoodProvider extends IlluminateServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NeighborhoodRepositoryInterface::class, NeighborhoodRepository::class);
        $this->app->bind(NeighborhoodApplicationServiceInterface::class, NeighborhoodApplicationService::class);
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
