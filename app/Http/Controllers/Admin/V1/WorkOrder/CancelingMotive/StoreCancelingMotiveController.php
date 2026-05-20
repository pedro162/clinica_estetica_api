<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Services\WorkOrder\CancelingMotive\StoreCancelingMotiveApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\CancelingMotive\StoreCancelingMotiveRequest;
use App\Http\Resources\V1\WorkOrder\CancelingMotive\StoreCancelingMotiveResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreCancelingMotiveController extends Controller
{
    protected StoreCancelingMotiveApplicationServiceInterface $service;

    public function __construct(StoreCancelingMotiveApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(StoreCancelingMotiveRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $result = $this->service->handler(CreateCancelingMotiveCommand::build($request->validated()));

            DB::commit();

            return ApiResponseClass::sendRequest(new StoreCancelingMotiveResource($result), 'Canceling motive stored successfully', JsonResponse::HTTP_CREATED);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
