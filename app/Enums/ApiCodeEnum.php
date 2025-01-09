<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Carlin\LaravelDict\Attributes\EnumClass;
use Carlin\LaravelDict\Attributes\EnumProperty;

#[EnumClass('ApiCodeEnum', '响应code枚举')]
class ApiCodeEnum extends BaseEnum
{
	#[EnumProperty(description: '请求成功')]
	public const SUCCESS = '000001';

	#[EnumProperty(description: '请求失败')]
	public const HTTP_BAD_REQUEST = '000400';

	#[EnumProperty(description: '授权失败')]
	public const HTTP_UNAUTHORIZED = '000401';

	#[EnumProperty(description: '禁止访问')]
	public const HTTP_FORBIDDEN = '000403';

	#[EnumProperty(description: '404 not found')]
	public const HTTP_NOTFOUND = '000404';

	#[EnumProperty(description: '请求方法不允许')]
	public const HTTP_METHOD_NOT_ALLOWED = '000405';

	#[EnumProperty(description: '请求太频繁')]
	public const HTTP_TOO_MANY_REQUESTS = '000429';

	#[EnumProperty(description: '表单提交异常')]
	public const HTTP_UNPROCESSABLE_ENTITY = '000422';

	#[EnumProperty(description: '系统内部错误')]
	public const HTTP_INTERNAL_SERVER_ERROR = '000500';
}
