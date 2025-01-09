<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Carlin\TranslateDrives\Supports\LangCode;
use Modules\Translation\Enums\TranslationProviderEnum;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译文本', description: '')]
class ExecuteTranslationRequest extends BaseRequest
{
    #[Property(title: '翻译驱动', description: '翻译服务提供商', type: 'string', example: 'baidu', enumClass: TranslationProviderEnum::class)]
    public string $drive;

    #[Property(title: '待翻译文本', type: 'string', example: '你好世界')]
    public string $query;

    #[Property(title: '目标语言', description: '目标语言代码', type: 'string', example: 'en')]
    public string $to;

    #[Property(title: '源语言', description: '默认auto自动检测', type: 'string', example: 'auto')]
    public string $from = LangCode::AUTO;

    public static function rules(): array
    {
        return [
            'drive' => ['required', 'string'],
            'query' => ['required', 'string'],
            'to' => ['required', 'string'],
            'from' => ['string'],
        ];
    }
}
