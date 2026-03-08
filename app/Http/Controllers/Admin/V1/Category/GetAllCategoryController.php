<?php

namespace App\Http\Controllers\Admin\V1\Category;

use App\Application\Services\Category\CategoryApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Category\GetAllCategoryRequest;
use App\Http\Resources\V1\Category\GetAllCategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetAllCategoryController extends Controller
{
    public function __construct(
        protected CategoryApplicationServiceInterface $service,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function __invoke(GetAllCategoryRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->getAll($request->all());
            DB::commit();
            return ApiResponseClass::sendRequest(new GetAllCategoryResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
