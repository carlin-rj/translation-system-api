<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '创建项目', description: '')]
class ProjectCreateRequest extends BaseRequest
{
    #[Property(title: '项目标识', type: 'string', example: 'wms')]
    public string $key;

    #[Property(title: '项目名称', type: 'string', example: '仓储管理系统')]
    public string $name;

    #[Property(title: '项目描述', type: 'string', example: '用于管理仓库库存', nullable: true)]
    public ?string $description = null;

    public static function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:50', 'unique:projects'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
