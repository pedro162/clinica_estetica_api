<?php

namespace App\Http\Controllers\Admin\V1\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Application\Services\Service\ServiceApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Service\StoreServiceRequest;
use App\Http\Resources\V1\Service\ServiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreServiceController extends Controller
{
    public function __construct(
        protected ServiceApplicationServiceInterface $service,
        protected ServiceRepositoryInterface $personRepository
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\Service\StoreServiceRequest  $request
     *
     * @return JsonResponse
     *
     * @throws HttpResponseException
     */
    public function __invoke(StoreServiceRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->store(CreateServiceCommand::build($request->validated()));
            DB::commit();
            return ApiResponseClass::sendRequest(new ServiceResource($data->refresh()), 'Service Created Successful', JsonResponse::HTTP_CREATED);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
