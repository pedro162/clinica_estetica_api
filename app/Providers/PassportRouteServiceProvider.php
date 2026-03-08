<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Http\Routes\AccessTokenController;

class PassportRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPassportRoutes();
    }

    protected function registerPassportRoutes(): void
    {
        Route::prefix('oauth')
            ->middleware(['api'])
            ->group(function () {
                Route::post('token', [AccessTokenController::class, 'issueToken'])
                    ->name('passport.token');
            });
    }
}
