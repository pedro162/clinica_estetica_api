<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\StoreWorkOrderRequest;
use App\Http\Resources\V1\WorkOrder\WorkOrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreWorkOrderController extends Controller
{
    public function __construct(
        protected WorkOrderApplicationServiceInterface $service,
        protected WorkOrderRepositoryInterface $workOrderRepository
    ) {
    }

    public function __invoke(StoreWorkOrderRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->store(CreateWorkOrderCommand::build($request->validated()));
            DB::commit();
            return ApiResponseClass::sendRequest(new WorkOrderResource($data), 'WorkOrder Created Successful', JsonResponse::HTTP_CREATED);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
