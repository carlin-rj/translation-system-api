<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '下一个翻译', description: '')]
class NextPendingTranslationRequest extends BaseRequest
{
    #[Property(title: '项目标识', type: 'string', example: 'wms', nullable: true)]
    public ?string $project_key = null;

    #[Property(title: '语言', type: 'string', example: 'en', nullable: true)]
    public ?string $language = null;

    public static function rules(): array
    {
        return [
            'project_key' => ['nullable', 'string', 'exists:projects,key'],
            'language' => ['nullable', 'string', 'exists:languages,code'],
        ];
    }
}
