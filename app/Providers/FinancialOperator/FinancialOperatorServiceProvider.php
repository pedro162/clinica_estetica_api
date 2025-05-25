<?php

namespace App\Providers\FinancialOperator;

use App\Application\Services\FinancialOperator\FinancialOperatorApplicationService;
use App\Application\Services\FinancialOperator\FinancialOperatorApplicationServiceInterface;
use App\Domain\FinancialOperator\Repositories\FinancialOperatorRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\FinancialOperator\FinancialOperatorRepository;
use Illuminate\Support\ServiceProvider;

class FinancialOperatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FinancialOperatorRepositoryInterface::class, FinancialOperatorRepository::class);
        $this->app->bind(FinancialOperatorApplicationServiceInterface::class, FinancialOperatorApplicationService::class);
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
