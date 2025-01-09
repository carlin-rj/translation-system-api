<?php

namespace Modules\Translation\Dto;

use App\Dto\BaseDto;

class ExecuteTranslationRespDto extends BaseDto
{
    public bool $success = false;

	public ?string $text = '';

	public ?string $error = '';
}
