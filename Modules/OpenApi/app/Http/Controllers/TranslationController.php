<?php

namespace Modules\OpenApi\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Carlin\LaravelDataSwagger\Attributes\Additional\ArrayObjectResource;
use Illuminate\Http\JsonResponse;
use Modules\OpenApi\Http\Requests\OpenApiBaseRequest;
use Modules\OpenApi\Http\Requests\TranslationCollectRequest;
use Modules\OpenApi\Http\Resources\TranslationResource;
use Modules\Translation\Services\TranslationService;
use OpenApi\Attributes\Tag;
use Carlin\LaravelDataSwagger\Attributes\Additional\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\SuccessResponse;
use Carlin\LaravelDataSwagger\Attributes\Post;
use Carlin\LaravelDataSwagger\Attributes\RequestBody;

#[Tag(self::TAG, description: '开放接口')]
class TranslationController extends Controller
{
    public const TAG = '公共接口/翻译收集';

    private TranslationService $service;

    public function __construct(TranslationService $service)
    {
        $this->service = $service;
    }


	#[Post(controller: self::class, method: __FUNCTION__, summary: '收集翻译', tags: [self::TAG])]
	#[RequestBody(dtoClass: TranslationCollectRequest::class)]
	#[SuccessResponse(content: new BaseResource())]
	public function collect(TranslationCollectRequest $request): JsonResponse
	{
		$this->service->collect($request->project(), $request);
		return ApiResponse::success();
	}

	#[Post(controller: self::class, method: __FUNCTION__, summary: '获取已翻译的数据', tags: [self::TAG])]
	#[SuccessResponse(content: new ArrayObjectResource(TranslationResource::class))]
	public function get(OpenApiBaseRequest $request): JsonResponse
	{
		$data = $this->service->getDataByProject($request->project());
		return ApiResponse::successForResource(TranslationResource::collection($data));
	}
}
