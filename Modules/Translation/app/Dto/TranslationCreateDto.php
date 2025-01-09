<?php

namespace Modules\Translation\Dto;

use App\Dto\BaseDto;

class TranslationCreateDto extends BaseDto
{
	public string $project_key;

	public string $key;

	public string $source_text;

	public string $language;

	public ?string $target_text = null;
}
