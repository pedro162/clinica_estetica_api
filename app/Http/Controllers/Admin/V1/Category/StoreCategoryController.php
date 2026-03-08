<?php

namespace App\Http\Controllers\Admin\V1\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Application\Services\Category\CategoryApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Category\StoreCategoryRequest;
use App\Http\Resources\V1\Category\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreCategoryController extends Controller
{
    public function __construct(
        protected CategoryApplicationServiceInterface $service,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function __invoke(StoreCategoryRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->service->store(CreateCategoryCommand::build($request->validated()));
            DB::commit();
            return ApiResponseClass::sendRequest(new CategoryResource($data->refresh()), 'Category Created Successful', JsonResponse::HTTP_CREATED);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
