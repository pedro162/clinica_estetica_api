<?php

namespace App\Http\Controllers\Admin\V1\WorkOrder\CancelingMotive;

use App\Application\Commands\WorkOrder\CancelingMotive\CreateCancelingMotiveCommand;
use App\Application\Services\WorkOrder\CancelingMotive\DeleteCancelingMotiveApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkOrder\CancelingMotive\DeleteCancelingMotiveRequest;
use App\Http\Resources\V1\WorkOrder\CancelingMotive\DeleteCancelingMotiveResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteCancelingMotiveController extends Controller
{
    protected DeleteCancelingMotiveApplicationServiceInterface $service;

    public function __construct(DeleteCancelingMotiveApplicationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(DeleteCancelingMotiveRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;

            $this->service->handler(CreateCancelingMotiveCommand::build($data));

            DB::commit();

            return ApiResponseClass::sendRequest(new DeleteCancelingMotiveResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
