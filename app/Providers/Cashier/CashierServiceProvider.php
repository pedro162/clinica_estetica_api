<?php

namespace App\Providers\Cashier;

use App\Application\Services\Cashier\CashierApplicationService;
use App\Application\Services\Cashier\CashierApplicationServiceInterface;
use App\Domain\Cashier\Repositories\CashierRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Cashier\CashierRepository;
use Illuminate\Support\ServiceProvider;

class CashierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CashierRepositoryInterface::class, CashierRepository::class);
        $this->app->bind(CashierApplicationServiceInterface::class, CashierApplicationService::class);
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
