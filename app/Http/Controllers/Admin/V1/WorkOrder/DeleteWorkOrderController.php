<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder;

use App\Application\Commands\WorkOrder\CreateWorkOrderCommand;
use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\WorkOrder\Repositories\WorkOrderRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\DestroyWorkOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteWorkOrderController extends Controller
{
    public function __construct(
        protected WorkOrderApplicationServiceInterface $service,
        protected WorkOrderRepositoryInterface $workOrderRepository
    ) {}

    public function __invoke(DestroyWorkOrderRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $this->service->destroy(CreateWorkOrderCommand::build($data));

            DB::commit();

            // 204 No Content: we do not need to return a resource payload
            return ApiResponseClass::sendRequest(null, '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
