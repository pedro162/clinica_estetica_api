<?php

namespace App\Providers\AccountReceivable;

use App\Application\Services\AccountReceivable\AccountReceivableApplicationService;
use App\Application\Services\AccountReceivable\AccountReceivableApplicationServiceInterface;
use App\Domain\AccountReceivable\Repositories\AccountReceivableRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\AccountReceivable\AccountReceivableRepository;
use Illuminate\Support\ServiceProvider;

class AccountReceivableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccountReceivableRepositoryInterface::class, AccountReceivableRepository::class);
        $this->app->bind(AccountReceivableApplicationServiceInterface::class, AccountReceivableApplicationService::class);
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
