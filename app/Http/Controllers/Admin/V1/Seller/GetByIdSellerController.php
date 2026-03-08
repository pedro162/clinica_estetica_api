<?php

namespace App\Http\Controllers\Admin\V1\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Application\Services\Seller\SellerApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Seller\ShowSellerRequest;
use App\Http\Resources\V1\Seller\SellerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetByIdSellerController extends Controller
{
    public function __construct(
        protected SellerApplicationServiceInterface $service,
        protected SellerRepositoryInterface $personRepository
    ) {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\V1\Seller\ShowSellerRequest  $request
     *
     * @param  int  $id
     *
     * @return JsonResponse
     *
     * @throws HttpResponseException
     */
    public function __invoke(ShowSellerRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $data = $this->service->findById(CreateSellerCommand::build(['id' => $id]));
            DB::commit();
            return ApiResponseClass::sendRequest(new SellerResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
