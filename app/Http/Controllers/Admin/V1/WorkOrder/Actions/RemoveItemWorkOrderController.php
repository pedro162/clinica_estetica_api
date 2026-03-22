<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\Actions;

use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RemoveItemWorkOrderController extends Controller
{
    public function __construct(
        protected WorkOrderApplicationServiceInterface $service
    ) {
    }

    public function __invoke($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $result = $this->service->removeItem($id);

            DB::commit();

            return ApiResponseClass::sendRequest($result, 'Item removed from WorkOrder successfully', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
