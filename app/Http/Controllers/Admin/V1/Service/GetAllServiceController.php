<?php

namespace App\Http\Controllers\Admin\V1\Service;

use App\Application\Services\Service\ServiceApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Service\GetAllServiceRequest;
use App\Http\Resources\V1\Service\GetAllServiceResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/v1/services",
 *     tags={"Service"},
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
 *             @OA\Items(ref="#/components/schemas/ServiceResponseSchema")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Not Found"),
 *     @OA\Response(response=500, description="Internal Server Error")
 * )
 */
class GetAllServiceController extends Controller
{
    public function __construct(
        protected ServiceApplicationServiceInterface $service,
        protected ServiceRepositoryInterface $personRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param GetAllServiceRequest $request
     * 
     * @return JsonResponse
     * 
     * @throws HttpResponseException
     */
    public function __invoke(GetAllServiceRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            DB::commit();
            return ApiResponseClass::sendRequest(new GetAllServiceResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();

            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
