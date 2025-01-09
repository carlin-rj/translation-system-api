<?php

namespace App\Http\Requests;


use App\Enums\MatchTypeEnum;
use OpenApi\Attributes\Items;
use Carlin\LaravelDataSwagger\Attributes\Property;

class BaseListRequest extends BaseRequest
{
    #[Property(title: '页码', type: 'integer', example: 1)]
    public int $page = 1;

    #[Property(title: '每页数量', type: 'integer', example: 20)]
    public int $per_page = 20;

    #[Property(title: '搜索类型', type: 'string', enumClass: MatchTypeEnum::class)]
    public string $match_type = MatchTypeEnum::EXACT;

    #[Property(title: '搜索字段', type: 'string')]
    public ?string $search_type = null;

    #[Property(title: '搜索内容', type: 'array', items: new Items(type: 'string'))]
    public ?array $search_content_arr = [];

    #[Property(title: '排序字段', type: 'string')]
    public ?string $sort_key = null;

    #[Property(title: '排序值', type: 'string', enum: ['asc', 'desc'])]
    public string $sort_value = 'desc';


    /**
     * 制定规则
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'page'     => ['required', 'integer', 'min:1'],
            'per_page'     => ['required', 'integer', 'min:1', 'max:10000'],
            'sort_value' => ['string', 'required_with:sort_key', 'in:asc,desc'],
            'sort_key'   => ['string', 'required_with:sort_value'],
        ];
    }
}
