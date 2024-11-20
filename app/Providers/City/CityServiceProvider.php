<?php

namespace App\Providers\City;

use App\Application\Services\City\CityApplicationService;
use App\Application\Services\City\CityApplicationServiceInterface;
use App\Domain\City\Repositories\CityRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\City\CityRepository;
use Illuminate\Support\ServiceProvider;

class CityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CityApplicationServiceInterface::class, CityApplicationService::class);
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
