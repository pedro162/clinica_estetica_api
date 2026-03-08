<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder;

use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\GetAllWorkOrderRequest;
use App\Http\Resources\V1\WorkOrder\GetAllWorkOrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetAllWorkOrderController extends Controller
{
    public function __construct(
        protected WorkOrderApplicationServiceInterface $service,
        protected WorkOrderRepositoryInterface $workOrderRepository
    ) {
    }

    public function __invoke(GetAllWorkOrderRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            DB::commit();
            return ApiResponseClass::sendRequest(new GetAllWorkOrderResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
