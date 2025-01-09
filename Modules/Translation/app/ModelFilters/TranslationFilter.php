<?php

declare(strict_types=1);

namespace Modules\Translation\ModelFilters;

use App\ModelFilters\BaseModelFilter;

class TranslationFilter extends BaseModelFilter
{
	public function projectKey(mixed $value): void
	{
		$this->where('project_key', $value);
	}

	public function language(mixed $value):void
	{
		$this->where('language', $value);
	}

	public function status(mixed $value):void
	{
		if ($value >= 0) {
			$this->where('status', $value);
		}
	}

	public function keyword($value): void
	{
		$this->where(function($query) use ($value) {
			return $query->where('key', 'like', "%{$value}%")
				->orWhere('source_text', 'like', "%{$value}%")
				->orWhere('target_text', 'like', "%{$value}%");
		});
	}
}
