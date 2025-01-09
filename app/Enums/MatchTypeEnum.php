<?php

declare(strict_types=1);

namespace App\Enums;


use Carlin\LaravelDict\Attributes\EnumProperty;

class MatchTypeEnum extends BaseEnum
{
    #[EnumProperty(description: '精确匹配')]
    public const EXACT = 'exact';

    #[EnumProperty(description: '模糊匹配')]
    public const FUZZY = 'fuzzy';
}
