<?php

namespace Modules\Translation\Dto;

use Carlin\TranslateDrives\Supports\LangCode;
use Spatie\LaravelData\Dto;

class ExecuteTranslationDto extends Dto
{
    public string $drive;

    public string $query;

    public string $to;

    public string $from = LangCode::AUTO;



}
