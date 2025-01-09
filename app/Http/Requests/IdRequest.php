<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(__CLASS__, title: 'id参数', description: 'id参数')]
class IdRequest extends BaseRequest
{
    #[Property(property: 'id', title: '数据id', type: 'integer', example: 1)]
    public int $id;
}
