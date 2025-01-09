<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Resources;

use App\Http\Resources\BaseResource;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译记录', description: '')]
class LanguagesResource extends BaseResource
{
    #[Property(title: '语言名称', type: 'string', example: '英语')]
    public string $name;

    #[Property(title: '语言code', type: 'string', example: 'en')]
    public string $code;
}
