<?php

namespace Modules\Translation\Dto;

use App\Dto\BaseDto;

class TranslationUpdateDto extends BaseDto
{
	public int $id;

	public string $target_text;
}
