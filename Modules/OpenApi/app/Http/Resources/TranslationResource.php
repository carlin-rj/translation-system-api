<?php

declare(strict_types=1);

namespace Modules\OpenApi\Http\Resources;

use App\Http\Resources\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译数据', description: '')]
class TranslationResource extends BaseResource
{
	#[Property(title: '翻译键名', type: 'string', example: 'common.submit')]
    public string $key;

    #[Property(title: '源文本', type: 'string', example: '提交')]
    public string $source_text;

    #[Property(title: '译文', type: 'string', example: 'Submit', nullable: true)]
    public ?string $target_text;

	#[Property(title: '目标语言', type: 'string', example: 'en')]
	public string $language;

}
