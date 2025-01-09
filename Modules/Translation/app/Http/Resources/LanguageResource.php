<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Resources;

use App\Http\Resources\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '语言信息', description: '')]
class LanguageResource extends BaseResource
{
    #[Property(title: '语言代码', type: 'string', example: 'en')]
    public string $code;

    #[Property(title: '语言名称', type: 'string', example: '英语')]
    public string $name;

    #[Property(title: '创建时间', type: 'string', example: '2024-01-01 00:00:00')]
    public string $created_at;

    #[Property(title: '更新时间', type: 'string', example: '2024-01-01 00:00:00')]
    public string $updated_at;
}
