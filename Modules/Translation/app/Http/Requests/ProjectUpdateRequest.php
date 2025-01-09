<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\IdRequest;
use Illuminate\Validation\Rule;
use Modules\Translation\Models\Project;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '更新项目请求', description: '')]
class ProjectUpdateRequest extends IdRequest
{
    #[Property(title: '项目名称', type: 'string', example: '仓储管理系统')]
    public string $name;

    #[Property(title: '项目描述', type: 'string', example: '用于管理仓库库存', nullable: true)]
    public ?string $description = null;

    public static function rules(): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists(Project::class, 'id')],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
