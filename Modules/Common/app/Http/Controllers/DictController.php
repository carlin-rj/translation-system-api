<?php

declare(strict_types=1);

namespace Modules\Common\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Carlin\LaravelDataSwagger\Attributes\Additional\ArrayObjectResource;
use Illuminate\Http\JsonResponse;
use Modules\Common\Http\Dto\Requests\DictGetDto;
use Modules\Common\Http\Dto\Responses\DictGetRespDto;
use Modules\Common\Http\Resources\DictResource;
use Modules\Common\Services\DictService;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Tag;
use Carlin\LaravelDataSwagger\Attributes\Additional\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\SuccessResponse;
use Carlin\LaravelDataSwagger\Attributes\Post;


#[Tag(self::TAG, description: '字典')]
class DictController extends Controller
{
    public const TAG = '公共/字典';

    private DictService $service;

    public function __construct(DictService $service)
    {
        $this->service = $service;
    }

    #[Post(controller: self::class, method: __FUNCTION__, description: '获取字典数据', summary: '获取字典数据', tags: [self::TAG])]
    #[SuccessResponse(content: new ArrayObjectResource(DictResource::class))]
    public function all(): JsonResponse
    {
        $result = $this->service->all();
        return ApiResponse::successForResource(DictResource::collection($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, description: '获取openapi字典数据', summary: '获取openapi字典数据', tags: [self::TAG])]
    #[SuccessResponse(content: new ArrayObjectResource(DictResource::class))]
    public function openApi(): JsonResponse
    {
        $result = $this->service->getByGroup('openApi');
        return ApiResponse::successForResource(DictResource::collection($result));
    }
}
