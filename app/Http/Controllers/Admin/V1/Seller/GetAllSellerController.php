<?php

namespace App\Http\Controllers\Admin\V1\Seller;

use App\Application\Services\Seller\SellerApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Seller\Repositories\SellerRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Seller\GetAllSellerRequest;
use App\Http\Resources\V1\Seller\GetAllSellerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/v1/services",
 *     tags={"Seller"},
 *     summary="Get all services",
 *     description="Retrieve a list of all services",
 *     security={{"passport":{}}},
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number for pagination",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Number of items per page",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/SellerResponseSchema")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Not Found"),
 *     @OA\Response(response=500, description="Internal Server Error")
 * )
 */
class GetAllSellerController extends Controller
{
    public function __construct(
        protected SellerApplicationServiceInterface $service,
        protected SellerRepositoryInterface $personRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param GetAllSellerRequest $request
     * 
     * @return JsonResponse
     * 
     * @throws HttpResponseException
     */
    public function __invoke(GetAllSellerRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            DB::commit();
            return ApiResponseClass::sendRequest(new GetAllSellerResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
