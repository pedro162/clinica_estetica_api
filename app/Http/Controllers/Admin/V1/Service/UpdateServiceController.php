<?php

namespace App\Http\Controllers\Admin\V1\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Application\Services\Service\ServiceApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Service\UpdateServiceRequest;
use App\Http\Resources\V1\Service\ServiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateServiceController extends Controller
{
    public function __construct(
        protected ServiceApplicationServiceInterface $service,
        protected ServiceRepositoryInterface $personRepository
    ) {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\Service\UpdateServiceRequest $request
     *
     * @param  int  $id
     *
     * @return JsonResponse
     *
     * @throws HttpResponseException
     */
    public function __invoke(UpdateServiceRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $requestData = $request->validated();
            $requestData['id'] = $id;
            $this->service->update(CreateServiceCommand::build($requestData));

            DB::commit();
            return ApiResponseClass::sendRequest(new ServiceResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
