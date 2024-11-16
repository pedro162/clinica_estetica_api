<?php

namespace App\Providers\City;

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
