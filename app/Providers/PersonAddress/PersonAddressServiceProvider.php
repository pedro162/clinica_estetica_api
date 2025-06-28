<?php

namespace App\Providers\PersonAddress;

use App\Application\Services\PersonAddress\PersonAddressApplicationService;
use App\Application\Services\PersonAddress\PersonAddressApplicationServiceInterface;
use App\Domain\PersonAddress\Repositories\PersonAddressRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\PersonAddress\PersonAddressRepository;
use Illuminate\Support\ServiceProvider;

class PersonAddressServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PersonAddressRepositoryInterface::class, PersonAddressRepository::class);
        $this->app->bind(PersonAddressApplicationServiceInterface::class, PersonAddressApplicationService::class);
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
