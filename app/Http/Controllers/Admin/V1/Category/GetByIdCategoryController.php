<?php

namespace App\Http\Controllers\Admin\V1\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Application\Services\Category\CategoryApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Category\ShowCategoryRequest;
use App\Http\Resources\V1\Category\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class GetByIdCategoryController extends Controller
{
    public function __construct(
        protected CategoryApplicationServiceInterface $service,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function __invoke(ShowCategoryRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validated();
            $data = $this->service->findById(CreateCategoryCommand::build(['id' => $id]));
            DB::commit();
            return ApiResponseClass::sendRequest(new CategoryResource($data), '', JsonResponse::HTTP_OK);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
