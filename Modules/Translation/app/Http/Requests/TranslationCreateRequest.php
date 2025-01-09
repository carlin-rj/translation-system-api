<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\Translation\Models\Language;
use Modules\Translation\Models\Project;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '创建翻译', description: '')]
class TranslationCreateRequest extends BaseRequest
{
    #[Property(title: '项目标识', type: 'string', example: 'wms')]
    public string $project_key;

    #[Property(title: '翻译键名', type: 'string', example: 'common.submit')]
    public string $key;

    #[Property(title: '源文本', type: 'string', example: '提交')]
    public string $source_text;

    #[Property(title: '目标语言', type: 'string', example: 'en')]
    public string $language;

    #[Property(title: '译文', type: 'string', example: 'Submit', nullable: true)]
    public ?string $target_text = null;

    public static function rules(): array
    {
        return [
            'project_key' => ['required', 'string', 'max:50', Rule::exists(Project::class, 'key')],
            'key' => ['required', 'string', 'max:100'],
            'source_text' => ['required', 'string'],
			'language' => ['required', 'string', 'max:20', Rule::exists(Language::class, 'code')],
            'target_text' => ['nullable', 'string'],
        ];
    }
}
