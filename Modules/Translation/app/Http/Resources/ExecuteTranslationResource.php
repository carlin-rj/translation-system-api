<?php

namespace Modules\Translation\Http\Resources;

use App\Http\Resources\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译响应', description: '')]
class ExecuteTranslationResource extends BaseResource
{
	#[Property(title: '是否成功', type: 'bool', example: false)]
	public bool $success = false;

	#[Property(title: '翻译字符', type: 'string', example: '')]
	public ?string $text = '';

	#[Property(title: '错误提示', type: 'string', example: '')]
	public ?string $error = '';
}
