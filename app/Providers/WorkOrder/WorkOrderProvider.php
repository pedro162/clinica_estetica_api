<?php

namespace App\Providers\WorkOrder;

use App\Application\Services\WorkOrder\CancelingMotive\DeleteCancelingMotiveApplicationService;
use App\Application\Services\WorkOrder\CancelingMotive\DeleteCancelingMotiveApplicationServiceInterface;
use App\Application\Services\WorkOrder\CancelingMotive\GetAllCancelingMotiveApplicationService;
use App\Application\Services\WorkOrder\CancelingMotive\GetAllCancelingMotiveApplicationServiceInterface;
use App\Application\Services\WorkOrder\CancelingMotive\GetByIdCancelingMotiveApplicationService;
use App\Application\Services\WorkOrder\CancelingMotive\GetByIdCancelingMotiveApplicationServiceInterface;
use App\Application\Services\WorkOrder\CancelingMotive\StoreCancelingMotiveApplicationService;
use App\Application\Services\WorkOrder\CancelingMotive\StoreCancelingMotiveApplicationServiceInterface;
use App\Application\Services\WorkOrder\CancelingMotive\UpdateCancelingMotiveApplicationService;
use App\Application\Services\WorkOrder\CancelingMotive\UpdateCancelingMotiveApplicationServiceInterface;
use App\Application\Services\WorkOrder\WorkOrderApplicationService;
use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Domain\WorkOrderCancelingMotive\Repositories\WorkOrderCancelingMotiveRepositoryInterface;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\WorkOrder\CancelingMotive\CancelingMotiveRepository;
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
        $this->app->bind(WorkOrderCancelingMotiveRepositoryInterface::class, CancelingMotiveRepository::class);
        $this->app->bind(StoreCancelingMotiveApplicationServiceInterface::class, StoreCancelingMotiveApplicationService::class);
        $this->app->bind(GetAllCancelingMotiveApplicationServiceInterface::class, GetAllCancelingMotiveApplicationService::class);
        $this->app->bind(GetByIdCancelingMotiveApplicationServiceInterface::class, GetByIdCancelingMotiveApplicationService::class);
        $this->app->bind(UpdateCancelingMotiveApplicationServiceInterface::class, UpdateCancelingMotiveApplicationService::class);
        $this->app->bind(DeleteCancelingMotiveApplicationServiceInterface::class, DeleteCancelingMotiveApplicationService::class);
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
