<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\Actions;

use App\Application\Services\WorkOrder\WorkOrderApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\Actions\FinalizeWorkOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FinalizeWorkOrderController extends Controller
{
    public function __construct(
        protected WorkOrderApplicationServiceInterface $service
    ) {
    }

    public function __invoke(FinalizeWorkOrderRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;

            $result = $this->service->finalize($data);

            DB::commit();

            return ApiResponseClass::sendRequest($result, 'WorkOrder finalized successfully', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
