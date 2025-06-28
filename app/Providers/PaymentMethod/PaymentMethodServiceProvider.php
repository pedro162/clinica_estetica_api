<?php

namespace App\Providers\PaymentMethod;

use App\Application\Services\PaymentMethod\PaymentMethodApplicationService;
use App\Application\Services\PaymentMethod\PaymentMethodApplicationServiceInterface;
use App\Domain\PaymentMethod\Repositories\PaymentMethodRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\PaymentMethod\PaymentMethodRepository;
use Illuminate\Support\ServiceProvider;

class PaymentMethodServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(PaymentMethodApplicationServiceInterface::class, PaymentMethodApplicationService::class);
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
