<?php

namespace App\Http\Controllers\Admin\V1\Neighborhood;

use App\Application\Commands\Neighborhood\CreateNeighborhoodCommand;
use App\Application\Services\Neighborhood\NeighborhoodApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Neighborhood\Repositories\NeighborhoodRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Neighborhood\ShowNeighborhoodRequest;
use App\Http\Resources\V1\Neighborhood\NeighborhoodResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetByIdNeighborhoodController extends Controller
{
    public function __construct(
        protected NeighborhoodApplicationServiceInterface $service,
        protected NeighborhoodRepositoryInterface $neighborhoodRepository
    ) {
    }

    public function __invoke(ShowNeighborhoodRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $data = $this->service->findById(CreateNeighborhoodCommand::build(['id' => $id]));
            DB::commit();

            return ApiResponseClass::sendRequest(new NeighborhoodResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
