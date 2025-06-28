<?php

namespace App\Providers\Person;

use App\Application\Services\Person\PersonApplicationService;
use App\Application\Services\Person\PersonApplicationServiceInterface;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Person\PersonRepository;
use Illuminate\Support\ServiceProvider;

class PersonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(PersonApplicationServiceInterface::class, PersonApplicationService::class);
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
