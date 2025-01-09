<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Carlin\LaravelDataSwagger\Attributes\Additional\ArrayObjectResource;
use Illuminate\Http\JsonResponse;
use Modules\Translation\Http\Resources\LanguageResource;
use Modules\Translation\Http\Requests\LanguageCreateRequest;
use Modules\Translation\Http\Requests\LanguageDestroyRequest;
use Modules\Translation\Http\Requests\LanguageListRequest;
use Modules\Translation\Http\Requests\LanguageUpdateRequest;
use Modules\Translation\Services\LanguageService;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Tag;
use Carlin\LaravelDataSwagger\Attributes\Additional\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\PageResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\SuccessResponse;
use Carlin\LaravelDataSwagger\Attributes\Post;
use Carlin\LaravelDataSwagger\Attributes\RequestBody;

#[Tag(self::TAG, description: '语言管理')]
class LanguageController extends Controller
{
    public const TAG = '语言管理';

    private LanguageService $service;

    public function __construct(LanguageService $service)
    {
        $this->service = $service;
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '获取语言列表', tags: [self::TAG])]
    #[RequestBody(dtoClass: LanguageListRequest::class)]
    #[SuccessResponse(content: new PageResource(LanguageResource::class))]
    public function list(LanguageListRequest $request): JsonResponse
    {
        $result = $this->service->list($request);
        return ApiResponse::successForResourcePage(LanguageResource::collection($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '创建语言', tags: [self::TAG])]
    #[RequestBody(dtoClass: LanguageCreateRequest::class)]
    #[SuccessResponse(content: new BaseResource(LanguageResource::class))]
    public function create(LanguageCreateRequest $request): JsonResponse
    {
        $result = $this->service->create($request);
        return ApiResponse::successForResource(LanguageResource::from($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '更新语言', tags: [self::TAG])]
    #[RequestBody(dtoClass: LanguageUpdateRequest::class)]
    #[SuccessResponse(content: new BaseResource(LanguageResource::class))]
    public function update(LanguageUpdateRequest $request): JsonResponse
    {
        $result = $this->service->update($request);
        return ApiResponse::successForResource(LanguageResource::from($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '删除语言', tags: [self::TAG])]
	#[RequestBody(dtoClass: LanguageDestroyRequest::class)]
	#[SuccessResponse(content: new BaseResource())]
    public function destroy(LanguageDestroyRequest $request): JsonResponse
    {
        $this->service->delete($request->code);
        return ApiResponse::success();
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '获取所有语言', tags: [self::TAG])]
    #[SuccessResponse(content: new ArrayObjectResource(LanguageResource::class))]
    public function all(): JsonResponse
    {
        $result = $this->service->all();
        return ApiResponse::successForResource(LanguageResource::collection($result));
    }
}
