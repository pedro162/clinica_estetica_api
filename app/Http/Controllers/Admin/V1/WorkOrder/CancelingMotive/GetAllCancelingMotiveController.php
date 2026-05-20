<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive;

use App\Application\Services\WorkOrder\CancelingMotive\GetAllCancelingMotiveApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\CancelingMotive\GetAllCancelingMotiveRequest;
use App\Http\Resources\V1\WorkOrder\CancelingMotive\GetAllCancelingMotiveResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetAllCancelingMotiveController extends Controller
{
    protected GetAllCancelingMotiveApplicationServiceInterface $service;

    public function __construct(GetAllCancelingMotiveApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(GetAllCancelingMotiveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $result = $this->service->handler($request->all());

            DB::commit();

            return ApiResponseClass::sendRequest(new GetAllCancelingMotiveResource($result), 'Canceling motives retrieved successfully', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
