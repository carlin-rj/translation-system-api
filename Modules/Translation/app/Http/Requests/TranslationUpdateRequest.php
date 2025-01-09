<?php

declare(strict_types=1);

namespace Modules\Translation\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Modules\Translation\Models\Translation;
use Carlin\LaravelDataSwagger\Attributes\Property;
use Carlin\LaravelDataSwagger\Attributes\Schema;

#[Schema(dtoClass: __CLASS__, title: '更新翻译', description: '')]
class TranslationUpdateRequest extends BaseRequest
{
	#[Property(title: 'ID', type: 'integer', example: 1)]
	public int $id;

	#[Property(title: '译文', type: 'string', example: 'Submit')]
	public string $target_text;

	public static function rules(): array
	{
		return [
			'id' => ['required', 'integer', Rule::exists(Translation::class, 'id')],
			'target_text' => ['required', 'string'],
		];
	}
}
