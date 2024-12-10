<?php

namespace App\Providers\AccountReceivableItem;

use App\Application\Services\AccountReceivableItem\AccountReceivableItemApplicationService;
use App\Application\Services\AccountReceivableItem\AccountReceivableItemApplicationServiceInterface;
use App\Domain\AccountReceivableItem\Repositories\AccountReceivableItemRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\AccountReceivableItem\AccountReceivableItemRepository;
use Illuminate\Support\ServiceProvider;

class AccountReceivableItemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccountReceivableItemRepositoryInterface::class, AccountReceivableItemRepository::class);
        $this->app->bind(AccountReceivableItemApplicationServiceInterface::class, AccountReceivableItemApplicationService::class);
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
