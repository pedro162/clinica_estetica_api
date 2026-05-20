<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Services\WorkOrder\CancelingMotive\UpdateCancelingMotiveApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\V1\WorkOrder\CancelingMotive\UpdateCancelingMotiveRequest;
use App\Http\Resources\V1\WorkOrder\CancelingMotive\UpdateCancelingMotiveResource;

class UpdateCancelingMotiveController extends Controller
{
    protected UpdateCancelingMotiveApplicationServiceInterface $service;

    public function __construct(UpdateCancelingMotiveApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(UpdateCancelingMotiveRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;

            $this->service->handler(CreateCancelingMotiveCommand::build($data));

            DB::commit();

            return ApiResponseClass::sendRequest(new UpdateCancelingMotiveResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
