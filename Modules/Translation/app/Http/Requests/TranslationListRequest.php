<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseListRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Translation\Enums\TranslationStatusEnum;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '查询翻译列表', description: '')]
class TranslationListRequest extends BaseListRequest
{
    #[Property(title: '项目标识', type: 'string', example: 'wms', nullable: true)]
    public ?string $project_key = null;

    #[Property(title: '目标语言', type: 'string', example: 'en', nullable: true)]
    public ?string $language = null;

    #[Property(title: '翻译状态', type: 'integer', example: -1, nullable: true, enumClass: TranslationStatusEnum::class)]
    public ?int $status = null;

    #[Property(title: '搜索关键词', type: 'string', example: 'submit', nullable: true)]
    public ?string $keyword = null;

    public static function rules(): array
    {
        $rules = parent::rules();

        return $rules + [
            'project_key' => ['nullable', 'string', 'max:50'],
            'language' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'integer', new EnumValue(TranslationStatusEnum::class)],
            'keyword' => ['nullable', 'string', 'max:100'],
        ];
    }
}
