<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use Carlin\LaravelDataSwagger\Attributes\Additional\ArrayObjectResource;
use Illuminate\Http\JsonResponse;
use Modules\Translation\Http\Resources\ProjectResource;
use Modules\Translation\Http\Requests\ProjectCreateRequest;
use Modules\Translation\Http\Requests\ProjectUpdateRequest;
use Modules\Translation\Services\ProjectService;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Tag;
use Carlin\LaravelDataSwagger\Attributes\Additional\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\SuccessResponse;
use Carlin\LaravelDataSwagger\Attributes\Post;
use Carlin\LaravelDataSwagger\Attributes\RequestBody;

#[Tag(self::TAG, description: '项目管理')]
class ProjectController extends Controller
{
    public const TAG = '项目管理';

    private ProjectService $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '获取项目列表', tags: [self::TAG])]
    #[SuccessResponse(content: new ArrayObjectResource(ProjectResource::class))]
    public function all(): JsonResponse
    {
        $result = $this->service->all();
        return ApiResponse::successForResource(ProjectResource::collection($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '创建项目', tags: [self::TAG])]
    #[RequestBody(dtoClass: ProjectCreateRequest::class)]
    #[SuccessResponse(content: new BaseResource(ProjectResource::class))]
    public function create(ProjectCreateRequest $request): JsonResponse
    {
        $result = $this->service->create($request);
        return ApiResponse::successForResource(ProjectResource::from($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '更新项目', tags: [self::TAG])]
    #[RequestBody(dtoClass: ProjectUpdateRequest::class)]
    #[SuccessResponse(content: new BaseResource())]
    public function update(ProjectUpdateRequest $request): JsonResponse
    {
        $this->service->update($request);
        return ApiResponse::success();
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '删除项目', tags: [self::TAG])]
    #[RequestBody(dtoClass: IdRequest::class)]
    #[SuccessResponse(content: new BaseResource())]
    public function destroy(IdRequest $request): JsonResponse
    {
        $this->service->delete($request->id);
        return ApiResponse::success();
    }
}
