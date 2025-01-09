<?php

declare(strict_types=1);

namespace Modules\Translation\Services;

use Carlin\LaravelTranslateDrives\Facades\TranslateManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\OpenApi\Http\Requests\TranslationCollectRequest;
use Modules\Translation\Dto\ExecuteTranslationDto;
use Modules\Translation\Dto\ExecuteTranslationRespDto;
use Modules\Translation\Dto\TranslationCreateDto;
use Modules\Translation\Dto\TranslationUpdateDto;
use Modules\Translation\Enums\TranslationStatusEnum;
use Modules\Translation\Exporters\ExportFactory;
use Modules\Translation\Http\Requests\ExportTranslationRequest;
use Modules\Translation\Http\Requests\NextPendingTranslationRequest;
use Modules\Translation\Http\Requests\TranslationListRequest;
use Modules\Translation\ModelFilters\TranslationFilter;
use Modules\Translation\Models\Project;
use Modules\Translation\Models\Translation;
use Throwable;

class TranslationService
{
    /**
     * 获取翻译列表
     */
    public function list(TranslationListRequest $request): LengthAwarePaginator
	{
		return Translation::filter($request->toArray(), TranslationFilter::class)
			->with(['languageInfo', 'projectInfo'])
			->orderByDesc('id')
			->paginate($request->per_page);
    }



    public function updateOrCreate(TranslationCreateDto $dto): Translation
    {
        return Translation::query()->updateOrCreate([
			'project_key'   => $dto->project_key,
			'key'           => $dto->key,
			'language'      => $dto->language,
		], [
			'project_key'   => $dto->project_key,
			'key'           => $dto->key,
			'source_text'   => $dto->source_text,
			'target_text'   => $dto->target_text,
			'language'      => $dto->language,
			'status'        => empty($dto->target_text) ? TranslationStatusEnum::WAITING : TranslationStatusEnum::COMPLETED,
        ]);
    }

    /**
     * 更新翻译
     */
    public function update(TranslationUpdateDto $dto): Translation
    {
        $translation = Translation::findOrFail($dto->id);
        $translation->update([
            'target_text' => $dto->target_text,
            'status' => empty($dto->target_text) ? TranslationStatusEnum::WAITING : TranslationStatusEnum::COMPLETED,
        ]);

        return $translation;
    }

    /**
     * 删除翻译
     */
    public function delete(int $id): void
    {
        Translation::findOrFail($id)->delete();
    }

    /**
     * 执行翻译
     */
    public function executeTranslation(ExecuteTranslationDto $dto): ExecuteTranslationRespDto
    {
        //多驱动实现
		$respDto = new ExecuteTranslationRespDto();
        try {
            $respDto->text =  TranslateManager::driver($dto->drive)->translate($dto->query, $dto->to)->getDst();
			$respDto->success = true;
        }catch (Throwable $e) {
			$respDto->success = false;
			$respDto->error = $e->getMessage();
        }
		return $respDto;
    }

    public function getStatusCounts(TranslationListRequest $request): array
    {
        $query = Translation::filter($request->toArray(), TranslationFilter::class);
        $result = $query->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = TranslationStatusEnum::getValues();
        $data = [];
        foreach ($statuses as $status) {
            $data[] = [
                'code' => $status,
                'name' => TranslationStatusEnum::getDescription($status),
                'count' => TranslationStatusEnum::ALL === $status ? array_sum($result) : ($result[$status] ?? 0)
            ];
        }

        return $data;
    }

    /**
     * 获取下一条待翻译内容
     */
    public function getNextPendingTranslation(NextPendingTranslationRequest $request): ?Translation
    {
		$query  = Translation::query()->where('status', TranslationStatusEnum::WAITING);

        if ($request->project_key) {
            $query->where('project_key', $request->project_key);
        }

        if ($request->language) {
            $query->where('language', $request->language);
        }

        return $query->orderBy('id')->first();
    }

    /**
     * 导出翻译
     */
    public function export(ExportTranslationRequest $request): string
    {
        return ExportFactory::make($request->type, $request->project_key)->export();
    }

	public function collect(Project $project, TranslationCollectRequest $data): void
	{
		DB::transaction(function () use ($project, $data) {
			foreach ($data->data as $item) {
				$dto = TranslationCreateDto::from($item, ['project_key' => $project->key]);
				$this->updateOrCreate($dto);
			}
		});
	}


	public function getDataByProject(Project $project): Collection
	{
		return Translation::query()
			->where('status', TranslationStatusEnum::COMPLETED)
			->where('project_key', $project->key)
			->get();
	}
}
