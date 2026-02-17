<?php

namespace App\Providers\Seller;

use App\Application\Services\Seller\SellerApplicationService;
use App\Application\Services\Seller\SellerApplicationServiceInterface;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Seller\SellerRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class SellerProvider extends IlluminateServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SellerRepositoryInterface::class, SellerRepository::class);
        $this->app->bind(SellerApplicationServiceInterface::class, SellerApplicationService::class);
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
