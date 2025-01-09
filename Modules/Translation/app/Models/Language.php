<?php

namespace Modules\Translation\Models;

use App\Models\BaseModel;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperLanguage
 */
class Language extends BaseModel
{
	use HasFactory, Filterable;

	/**
	 * 可批量赋值的属性
	 */
	protected $guarded = [];

	/**
	 * 属性类型转换
	 */
	protected $casts = [
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
	];
}
