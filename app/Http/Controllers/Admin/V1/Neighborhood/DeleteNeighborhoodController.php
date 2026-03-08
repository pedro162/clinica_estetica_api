<?php

namespace App\Http\Controllers\Admin\V1\Neighborhood;

use App\Application\Commands\Neighborhood\CreateNeighborhoodCommand;
use App\Application\Services\Neighborhood\NeighborhoodApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Neighborhood\Repositories\NeighborhoodRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Neighborhood\DestroyNeighborhoodRequest;
use App\Http\Resources\V1\Neighborhood\NeighborhoodResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteNeighborhoodController extends Controller
{
    public function __construct(
        protected NeighborhoodApplicationServiceInterface $service,
        protected NeighborhoodRepositoryInterface $neighborhoodRepository
    ) {
    }

    public function __invoke(DestroyNeighborhoodRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['id'] = $id;
            $this->service->destroy(CreateNeighborhoodCommand::build($data));

            DB::commit();

            return ApiResponseClass::sendRequest(new NeighborhoodResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
