<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Resources;

use App\Http\Resources\BaseResource;
use Modules\Translation\Enums\TranslationStatusEnum;
use Modules\Translation\Models\Translation;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译记录', description: '')]
class TranslationResource extends BaseResource
{
    #[Property(title: 'ID', type: 'integer', example: 1)]
    public int $id;

    #[Property(title: '项目标识', type: 'string', example: 'wms')]
    public string $project_key;

	#[Property(title: '项目名称', type: 'string', example: '仓储系统')]
	public string $project_name;


	#[Property(title: '翻译键名', type: 'string', example: 'common.submit')]
    public string $key;

    #[Property(title: '源文本', type: 'string', example: '提交')]
    public string $source_text;

    #[Property(title: '译文', type: 'string', example: 'Submit', nullable: true)]
    public ?string $target_text;

    #[Property(title: '目标语言', type: 'string', example: 'en')]
    public string $language;

    #[Property(title: '语言名称', type: 'string', example: '英语')]
    public string $language_name;

    #[Property(title: '翻译状态', description: '0待翻译，1已翻译', type: 'integer', example: 1)]
    public int $status;

	#[Property(title: '翻译状态', description: '待翻译，已翻译', type: 'string', example: '待翻译')]
	public string $status_text;

    #[Property(title: '创建时间', type: 'string', example: '2024-03-20 10:00:00')]
    public string $created_at;

    #[Property(title: '更新时间', type: 'string', example: '2024-03-20 10:00:00')]
    public string $updated_at;

	/**
	 * @param array $properties
	 * @param Translation $payload
	 * @return array
	 */
    public static function beforeFill(array $properties, mixed $payload): array
    {
        // 如果需要在填充数据前进行一些处理，可以在这里实现
		return [
			...$properties,
			...[
				'project_name'=>$payload->projectInfo->name,
				'language_name'=>$payload->languageInfo->name,
				'status_text'=>TranslationStatusEnum::getDescription($payload->status),
			]
		];
    }
}
