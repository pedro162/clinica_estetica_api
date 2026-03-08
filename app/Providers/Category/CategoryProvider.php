<?php

namespace App\Providers\Category;

use App\Application\Services\Category\CategoryApplicationService;
use App\Application\Services\Category\CategoryApplicationServiceInterface;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Category\CategoryRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class CategoryProvider extends IlluminateServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryApplicationServiceInterface::class, CategoryApplicationService::class);
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
