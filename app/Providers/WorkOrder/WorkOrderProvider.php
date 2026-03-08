<?php

namespace App\Providers\WorkOrder;

use App\Application\Services\WorkOrder\WorkOrderApplicationService;
use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\WorkOrder\WorkOrderRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class WorkOrderProvider extends IlluminateServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WorkOrderRepositoryInterface::class, WorkOrderRepository::class);
        $this->app->bind(WorkOrderApplicationServiceInterface::class, WorkOrderApplicationService::class);
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
