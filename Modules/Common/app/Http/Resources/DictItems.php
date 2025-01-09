<?php

declare(strict_types=1);

namespace Modules\Common\Http\Resources;

use App\Http\Resources\BaseResource;
use OpenApi\Attributes\Schema as OpenApiSchema;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass:__CLASS__, title: '字典值', description: '')]
class DictItems extends BaseResource
{
    #[Property(title: '字典项名', type: 'string')]
    public string $description;

    #[Property(title: '字典项值', oneOf: [new OpenApiSchema(type: 'string'), new OpenApiSchema(type: 'integer')])]
    public string|int $value;
}
