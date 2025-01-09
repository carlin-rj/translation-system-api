<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Resources;

use App\Http\Resources\BaseResource;
use Modules\Translation\Enums\TranslationStatusEnum;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译状态统计', description: '')]
class StatusCountResource extends BaseResource
{
    #[Property(title: '状态编码', type: 'integer', example: 0, enumClass: TranslationStatusEnum::class)]
    public int $code;

    #[Property(title: '状态名称', type: 'string', example: '待翻译')]
    public string $name;

    #[Property(title: '数量', type: 'integer', example: 10)]
    public int $count;
}
