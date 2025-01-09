<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Resources;

use App\Http\Resources\BaseResource;
use Modules\Translation\Models\Project;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '项目信息', description: '')]
class ProjectResource extends BaseResource
{
    #[Property(title: 'ID', type: 'integer', example: 1)]
    public int $id;

    #[Property(title: '项目标识', type: 'string', example: 'wms')]
    public string $key;

    #[Property(title: '项目名称', type: 'string', example: '仓储管理系统')]
    public string $name;

    #[Property(title: '项目描述', type: 'string', example: '用于管理仓库库存', nullable: true)]
    public ?string $description;

	#[Property(title: 'api_token', type: 'string', example: 'app_token_987654321', nullable: true)]
	public ?string $api_token;


	#[Property(title: '待翻译数量', type: 'integer', example: 0, nullable: true)]
	public ?int $translations_count = 0;

	#[Property(title: '已翻译数量', type: 'integer', example: 0, nullable: true)]
	public ?int $translated_translations_count = 0;

    #[Property(title: '状态', type: 'integer', example: 1)]
    public int $status;

    #[Property(title: '创建时间', type: 'string', example: '2024-03-20 10:00:00')]
    public string $created_at;

    #[Property(title: '更新时间', type: 'string', example: '2024-03-20 10:00:00')]
    public string $updated_at;

}
