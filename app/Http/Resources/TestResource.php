<?php

namespace App\Http\Resources;


use App\Models\DataCollectVideos;
use OpenApi\Attributes\Items;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '响应结果2', description: '')]
class TestResource extends BaseResource
{
    #[Property(title: 'doc_system_uuid', description: 'testes', type: 'string', example: 1)]
    public string $doc_system_uuid;

    #[Property(title: 'menu_id', type: 'integer', example: 1)]
    public int|null $menu_id = 0;

    #[Property(title: 'type', type: 'integer', example: 1)]
    public int $type;

    #[Property(title: 'items', type: 'array', items: new Items(ref: TestItems::class))]
    #[DataCollectionOf(TestItems::class)]
    public array $items = [];


    public static function beforeFill(array $properties, mixed $payload = null): array
    {
        $properties['items'] = DataCollectVideos::query()->paginate(3);
        return $properties;
    }
}
