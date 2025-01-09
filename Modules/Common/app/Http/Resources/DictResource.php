<?php

namespace Modules\Common\Http\Resources;

use App\Http\Resources\BaseResource;
use OpenApi\Attributes\Items;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '字典', description: '')]
class DictResource extends BaseResource
{
    #[Property(title: '字典名', type: 'string')]
    public string $name;

    #[Property(title: '描述', type: 'string')]
    public string $description;

    #[Property(title: '字典项', type: 'array', items: new Items(ref: DictItems::class))]
    public array $data;
}
