<?php

namespace App\Providers\Country;

use App\Application\Services\Country\CountryApplicationService;
use App\Application\Services\Country\CountryApplicationServiceInterface;
use App\Domain\Country\Repositories\CountryRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Country\CountryRepository;
use Illuminate\Support\ServiceProvider;

class CountryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(CountryApplicationServiceInterface::class, CountryApplicationService::class);
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
