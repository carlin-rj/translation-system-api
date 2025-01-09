<?php

declare(strict_types=1);

namespace Modules\Translation\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Translation\Http\Requests\LanguageListRequest;
use Modules\Translation\Http\Requests\LanguageCreateRequest;
use Modules\Translation\Http\Requests\LanguageUpdateRequest;
use Modules\Translation\ModelFilters\LanguageFilter;
use Modules\Translation\Models\Language;

class LanguageService
{
	/**
	 * @return Collection<int, Language>
	 * @author: whj
	 * @date: 2025/1/3 上午10:48
	 */
	public function all(): Collection
	{
		return Language::all();
	}

	/**
	 * 获取语言列表
	 */
	public function list(LanguageListRequest $request): LengthAwarePaginator
	{
		$query = Language::filter($request->toArray(), LanguageFilter::class);
		return $query->orderByDesc('id')->paginate($request->per_page);
	}

	/**
	 * 创建语言
	 */
	public function create(LanguageCreateRequest $request): Language
	{
		return Language::create([
			'code' => $request->code,
			'name' => $request->name,
		]);
	}

	/**
	 * 更新语言
	 */
	public function update(LanguageUpdateRequest $request): Language
	{
		$language = Language::where('code', $request->code)->firstOrFail();
		$language->update([
			'name' => $request->name,
		]);

		return $language;
	}

	/**
	 * 删除语言
	 */
	public function delete(string $code): void
	{
		Language::where('code', $code)->firstOrFail()->delete();
	}
}
