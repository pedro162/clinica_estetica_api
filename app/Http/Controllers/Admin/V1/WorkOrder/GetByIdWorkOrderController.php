<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\ShowWorkOrderRequest;
use App\Http\Resources\V1\WorkOrder\WorkOrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetByIdWorkOrderController extends Controller
{
    public function __construct(
        protected WorkOrderApplicationServiceInterface $service,
        protected WorkOrderRepositoryInterface $workOrderRepository
    ) {
    }

    public function __invoke(ShowWorkOrderRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $data = $this->service->findById(CreateWorkOrderCommand::build(['id' => $id]));
            DB::commit();
            return ApiResponseClass::sendRequest(new WorkOrderResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
