<?php

namespace Modules\Translation\Enums;

use App\Enums\BaseEnum;
use Carlin\TranslateDrives\Supports\Provider;
use Carlin\LaravelDict\Attributes\EnumClass;
use Carlin\LaravelDict\Attributes\EnumProperty;

#[EnumClass('TranslationProviderEnum', '翻译驱动')]
class TranslationProviderEnum  extends BaseEnum
{
	#[EnumProperty('谷歌翻译')]
	public const GOOGLE = Provider::GOOGLE;

	#[EnumProperty('阿里云翻译')]
	public const ALIBABA_CLOUD = Provider::ALIBABA_CLOUD;

	#[EnumProperty('百度翻译')]
	public const BAIDU = Provider::BAIDU;

}
