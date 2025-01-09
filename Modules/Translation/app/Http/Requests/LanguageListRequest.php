<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseListRequest;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '语种搜索', description: '')]
class LanguageListRequest extends BaseListRequest
{
    #[Property(title: '搜索关键词', type: 'string', example: 'en', nullable: true)]
    public ?string $keyword = null;

    public static function rules(): array
    {
        $rules = parent::rules();

        return $rules + [
            'keyword' => ['nullable', 'string', 'max:50'],
        ];
    }
}
