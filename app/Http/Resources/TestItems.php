<?php

namespace App\Http\Resources;


use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '响应结果2', description: '')]
class TestItems extends BaseResource
{
    #[Property(title: 'doc_system_uuid', type: 'string', example: 1)]
    public string $doc_system_uuid;
    //
    #[Property(title: 'menu_id', type: 'integer', example: 1)]
    public int|null $menu_id = 0;

    #[Property(title: 'type', type: 'integer', example: 1)]
    public int $type;

    #[Property(title: 'type_text', type: 'string', example: 1)]
    public string $type_text;


    public static function beforeFill(array $properties, mixed $payload): array
    {
        $properties['type_text'] = $payload->id;
        return $properties;
    }


}
