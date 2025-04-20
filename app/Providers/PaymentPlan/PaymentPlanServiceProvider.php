<?php

namespace App\Providers\PaymentPlan;

use App\Application\Services\PaymentPlan\PaymentPlanApplicationService;
use App\Application\Services\PaymentPlan\PaymentPlanApplicationServiceInterface;
use App\Domain\PaymentPlan\Repositories\PaymentPlanRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\PaymentPlan\PaymentPlanRepository;
use Illuminate\Support\ServiceProvider;

class PaymentPlanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentPlanRepositoryInterface::class, PaymentPlanRepository::class);
        $this->app->bind(PaymentPlanApplicationServiceInterface::class, PaymentPlanApplicationService::class);
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
