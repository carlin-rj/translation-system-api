<?php

namespace Modules\Translation\Enums;

use App\Enums\BaseEnum;
use Carlin\LaravelDict\Attributes\EnumClass;
use Carlin\LaravelDict\Attributes\EnumProperty;

#[EnumClass('TranslationStatusEnum', '翻译状态')]
class TranslationStatusEnum extends BaseEnum
{
	#[EnumProperty('全部')]
	public const ALL = -1;

	#[EnumProperty('待翻译')]
	public const WAITING = 1;

	#[EnumProperty('已翻译')]
	public const COMPLETED = 2;


}
