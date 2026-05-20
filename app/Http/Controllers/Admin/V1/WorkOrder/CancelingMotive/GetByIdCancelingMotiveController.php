<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Services\WorkOrder\CancelingMotive\GetByIdCancelingMotiveApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\CancelingMotive\GetByIdCancelingMotiveRequest;
use App\Http\Resources\V1\WorkOrder\CancelingMotive\GetByIdCancelingMotiveResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetByIdCancelingMotiveController extends Controller
{
    protected GetByIdCancelingMotiveApplicationServiceInterface $service;

    public function __construct(GetByIdCancelingMotiveApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(GetByIdCancelingMotiveRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $result = $this->service->handler(CreateCancelingMotiveCommand::build(['id' => $id]));

            DB::commit();

            return ApiResponseClass::sendRequest(new GetByIdCancelingMotiveResource($result), 'Canceling motive retrieved successfully', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
