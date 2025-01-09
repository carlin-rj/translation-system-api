<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use Carlin\LaravelDataSwagger\Attributes\Additional\ArrayObjectResource;
use Illuminate\Http\JsonResponse;
use Modules\Translation\Http\Resources\ExecuteTranslationResource;
use Modules\Translation\Http\Resources\StatusCountResource;
use Modules\Translation\Http\Resources\TranslationResource;
use Modules\Translation\Dto\ExecuteTranslationDto;
use Modules\Translation\Dto\TranslationCreateDto;
use Modules\Translation\Dto\TranslationUpdateDto;
use Modules\Translation\Http\Requests\ExecuteTranslationRequest;
use Modules\Translation\Http\Requests\ExportTranslationRequest;
use Modules\Translation\Http\Requests\NextPendingTranslationRequest;
use Modules\Translation\Http\Requests\TranslationCreateRequest;
use Modules\Translation\Http\Requests\TranslationListRequest;
use Modules\Translation\Http\Requests\TranslationUpdateRequest;
use Modules\Translation\Services\TranslationService;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Carlin\LaravelDataSwagger\Attributes\Additional\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\PageResource;
use Carlin\LaravelDataSwagger\Attributes\Additional\SuccessResponse;
use Carlin\LaravelDataSwagger\Attributes\Post;
use Carlin\LaravelDataSwagger\Attributes\RequestBody;

#[Tag(self::TAG, description: '翻译管理')]
class TranslationController extends Controller
{
    public const TAG = '翻译管理';

    private TranslationService $service;

    public function __construct(TranslationService $service)
    {
        $this->service = $service;
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '获取翻译列表', tags: [self::TAG])]
    #[RequestBody(dtoClass: TranslationListRequest::class)]
    #[SuccessResponse(content: new PageResource(TranslationResource::class))]
    public function list(TranslationListRequest $request): JsonResponse
    {
        $result = $this->service->list($request);
        return ApiResponse::successForResourcePage(TranslationResource::collection($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '创建翻译', tags: [self::TAG])]
    #[RequestBody(dtoClass: TranslationCreateRequest::class)]
    #[SuccessResponse(content: new BaseResource(TranslationResource::class))]
    public function create(TranslationCreateRequest $request): JsonResponse
    {
		$dto = TranslationCreateDto::from($request);
        $result = $this->service->updateOrCreate($dto);
        return ApiResponse::successForResource(TranslationResource::from($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '更新翻译', tags: [self::TAG])]
    #[RequestBody(dtoClass: TranslationUpdateRequest::class)]
    #[SuccessResponse(content: new BaseResource())]
    public function update(TranslationUpdateRequest $request): JsonResponse
    {
		$dto = TranslationUpdateDto::from($request);
        $this->service->update($dto);
		return ApiResponse::success();
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '删除翻译', tags: [self::TAG])]
	#[RequestBody(dtoClass: IdRequest::class)]
	#[SuccessResponse(content: new BaseResource())]
    public function destroy(IdRequest $request): JsonResponse
    {
        $this->service->delete($request->id);
        return ApiResponse::success();
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '执行翻译', tags: [self::TAG])]
    #[RequestBody(dtoClass: ExecuteTranslationRequest::class)]
    #[SuccessResponse(content: new BaseResource(dtoClass: ExecuteTranslationResource::class))]
    public function executeTranslation(ExecuteTranslationRequest $request): JsonResponse
    {
        $dto = ExecuteTranslationDto::from($request);
        $data = $this->service->executeTranslation($dto);
        return ApiResponse::successForResource(ExecuteTranslationResource::from($data));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '获取翻译状态统计', tags: [self::TAG])]
    #[RequestBody(dtoClass: TranslationListRequest::class)]
    #[SuccessResponse(content: new ArrayObjectResource(StatusCountResource::class))]
    public function statusCounts(TranslationListRequest $request): JsonResponse
    {
        $result = $this->service->getStatusCounts($request);
        return ApiResponse::successForResource(StatusCountResource::collection($result));
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '获取下一条待翻译内容', tags: [self::TAG])]
    #[RequestBody(dtoClass: NextPendingTranslationRequest::class)]
    #[SuccessResponse(content: new BaseResource(TranslationResource::class))]
    public function nextPendingTranslation(NextPendingTranslationRequest $request): JsonResponse
    {
        $result = $this->service->getNextPendingTranslation($request);
        return ApiResponse::successForResource($result ? TranslationResource::from($result) : null);
    }

    #[Post(controller: self::class, method: __FUNCTION__, summary: '导出翻译', tags: [self::TAG])]
    #[RequestBody(dtoClass: ExportTranslationRequest::class)]
    #[SuccessResponse(content: new MediaType('application/zip'))]
    public function export(ExportTranslationRequest $request): BinaryFileResponse
    {
        $filePath = $this->service->export($request);
        return response()->download($filePath)->deleteFileAfterSend();
    }

}
