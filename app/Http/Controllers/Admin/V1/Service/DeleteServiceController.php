<?php

namespace App\Http\Controllers\Admin\V1\Service;

use App\Application\Commands\Service\CreateServiceCommand;
use App\Application\Services\Service\ServiceApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Service\DestroyServiceRequest;
use App\Http\Resources\V1\Service\ServiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteServiceController extends Controller
{
    public function __construct(
        protected ServiceApplicationServiceInterface $service,
        protected ServiceRepositoryInterface $personRepository
    ) {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\Service\DestroyServiceRequest $request
     * @param  int  $id
     * @return JsonResponse
     *
     * @throws HttpResponseException
     */
    public function __invoke(DestroyServiceRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $data = $this->service->destroy(CreateServiceCommand::build($data));

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
