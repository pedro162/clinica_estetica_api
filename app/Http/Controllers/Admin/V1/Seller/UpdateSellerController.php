<?php

namespace App\Http\Controllers\Admin\V1\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Application\Services\Seller\SellerApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Seller\UpdateSellerRequest;
use App\Http\Resources\V1\Seller\SellerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateSellerController extends Controller
{
    public function __construct(
        protected SellerApplicationServiceInterface $service,
        protected SellerRepositoryInterface $personRepository
    ) {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\Seller\UpdateSellerRequest $request
     *
     * @param  int  $id
     *
     * @return JsonResponse
     *
     * @throws HttpResponseException
     */
    public function __invoke(UpdateSellerRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $requestData = $request->validated();
            $requestData['id'] = $id;
            $this->service->update(CreateSellerCommand::build($requestData));

            DB::commit();
            return ApiResponseClass::sendRequest(new SellerResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
