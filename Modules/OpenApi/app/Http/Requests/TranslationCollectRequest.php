<?php

declare(strict_types=1);

namespace Modules\OpenApi\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Translation\Models\Language;
use OpenApi\Attributes\Items;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '翻译数据', description: '')]
class TranslationCollectRequest extends OpenApiBaseRequest
{
	#[Property(title: '数据', type: 'array', items: new Items(ref: CollectDataItems::class))]
	#[DataCollectionOf(CollectDataItems::class)]
	public array $data;

	public static function rules(): array
	{
		return [
			'data'=>['required', 'array'],
			'data.*.key' => ['required', 'string', 'max:100'],
			'data.*.source_text' => ['required', 'string'],
			'data.*.language' => ['required', 'string', 'max:20', Rule::exists(Language::class, 'code')],
			'data.*.target_text' => ['nullable', 'string'],
		];
	}


	public static function attributes(): array
	{
		return [

		];
	}
}
