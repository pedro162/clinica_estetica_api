<?php

namespace App\Providers\CreditCardBrand;

use App\Application\Services\CreditCardBrand\CreditCardBrandApplicationService;
use App\Application\Services\CreditCardBrand\CreditCardBrandApplicationServiceInterface;
use App\Domain\CreditCardBrand\Repositories\CreditCardBrandRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\CreditCardBrand\CreditCardBrandRepository;
use Illuminate\Support\ServiceProvider;

class CreditCardBrandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CreditCardBrandRepositoryInterface::class, CreditCardBrandRepository::class);
        $this->app->bind(CreditCardBrandApplicationServiceInterface::class, CreditCardBrandApplicationService::class);
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
