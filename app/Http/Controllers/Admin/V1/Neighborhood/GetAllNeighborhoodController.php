<?php

namespace App\Http\Controllers\Admin\V1\Neighborhood;

use App\Application\Services\Neighborhood\NeighborhoodApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Neighborhood\Repositories\NeighborhoodRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Neighborhood\GetAllNeighborhoodRequest;
use App\Http\Resources\V1\Neighborhood\GetAllNeighborhoodResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetAllNeighborhoodController extends Controller
{
    public function __construct(
        protected NeighborhoodApplicationServiceInterface $service,
        protected NeighborhoodRepositoryInterface $neighborhoodRepository
    ) {
    }

    public function __invoke(GetAllNeighborhoodRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            DB::commit();

            return ApiResponseClass::sendRequest(new GetAllNeighborhoodResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
