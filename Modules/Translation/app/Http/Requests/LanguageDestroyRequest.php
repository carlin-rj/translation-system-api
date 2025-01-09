<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '语种删除', description: '')]
class LanguageDestroyRequest extends BaseRequest
{
    #[Property(title: '语言代码', type: 'string', example: 'en')]
    public string $code;


    public static function rules(): array
    {
        return [
            'code' => ['required', 'string'],
        ];
    }
}
