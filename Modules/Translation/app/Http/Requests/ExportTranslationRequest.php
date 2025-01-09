<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Translation\Enums\ExportTypeEnum;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '导出翻译', description: '')]
class ExportTranslationRequest extends BaseRequest
{
    #[Property(title: '项目key', type: 'string', example: 'web_admin')]
    public string $project_key;

    #[Property(title: '导出类型', type: 'string', enumClass: ExportTypeEnum::class)]
    public string $type;

    public static function rules(): array
    {
        return [
            'project_key' => ['required', 'string'],
            'type' => ['required', 'string', new EnumValue(ExportTypeEnum::class)],
        ];
    }
}
