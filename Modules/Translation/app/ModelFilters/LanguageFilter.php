<?php

declare(strict_types=1);

namespace Modules\Translation\ModelFilters;

use App\ModelFilters\BaseModelFilter;

class LanguageFilter extends BaseModelFilter
{
	public function keyword($value): void
	{
		$this->where(function ($query) use ($value) {
			$query->where('code', 'like', "%{$value}%")
				->orWhere('name', 'like', "%{$value}%");
		});
	}
}
