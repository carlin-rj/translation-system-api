<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\Translation\Models\Language;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '创建语种', description: '')]
class LanguageCreateRequest extends BaseRequest
{
    #[Property(title: '语言代码', type: 'string', example: 'en')]
    public string $code;

    #[Property(title: '语言名称', type: 'string', example: '英语')]
    public string $name;


    public static function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:10', 'regex:/^[a-z]{2}(-[A-Z]{2})?$/', Rule::unique(Language::class, 'code')],
            'name' => ['required', 'string', 'max:50'],
        ];
    }
}
