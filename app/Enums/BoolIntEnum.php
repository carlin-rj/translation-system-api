<?php

namespace App\Enums;

use Carlin\LaravelDict\Attributes\EnumClass;
use Carlin\LaravelDict\Attributes\EnumProperty;

#[EnumClass('BoolIntEnum', '布尔整型枚举')]
class BoolIntEnum extends BaseEnum
{
    #[EnumProperty('是')]
    public const TRUE = 1;

    #[EnumProperty('否')]
    public const FALSE = 0;
}
