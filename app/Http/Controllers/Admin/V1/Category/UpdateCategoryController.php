<?php

namespace App\Http\Controllers\Admin\V1\Category;

use App\Application\Commands\Category\CreateCategoryCommand;
use App\Application\Services\Category\CategoryApplicationServiceInterface;
use App\Classes\ApiResponseClass;
use App\Domain\Category\Repositories\CategoryRepositoryInterface;
use App\Exceptions\ServicoException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Category\UpdateCategoryRequest;
use App\Http\Resources\V1\Category\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateCategoryController extends Controller
{
    public function __construct(
        protected CategoryApplicationServiceInterface $service,
        protected CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function __invoke(UpdateCategoryRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $requestData = $request->validated();
            $requestData['id'] = $id;
            $this->service->update(CreateCategoryCommand::build($requestData));

            DB::commit();
            return ApiResponseClass::sendRequest(new CategoryResource([]), '', JsonResponse::HTTP_NO_CONTENT);
        } catch (ServicoException $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollback();
            ApiResponseClass::throw($e, $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
