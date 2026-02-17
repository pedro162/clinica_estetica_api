<?php

namespace App\Http\Controllers\Admin\V1\Seller;

use App\Application\Commands\Seller\CreateSellerCommand;
use App\Application\Services\Seller\SellerApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Seller\DestroySellerRequest;
use App\Http\Resources\V1\Seller\SellerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteSellerController extends Controller
{
    public function __construct(
        protected SellerApplicationServiceInterface $service,
        protected SellerRepositoryInterface $personRepository
    ) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\V1\Seller\DestroySellerRequest $request
     * @param  int  $id
     * @return JsonResponse
     * 
     * @throws HttpResponseException
     */
    public function __invoke(DestroySellerRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $data = $this->service->destroy(CreateSellerCommand::build($data));

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
