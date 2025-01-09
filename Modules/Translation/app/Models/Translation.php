<?php

namespace Modules\Translation\Models;

use App\Models\BaseModel;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperTranslation
 */
class Translation extends BaseModel
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
		'status' => 'integer',
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
	];


	public function languageInfo(): HasOne
	{
		return $this->hasOne(Language::class, 'code', 'language');
	}


	public function projectInfo():HasOne
	{
		return $this->hasOne(Project::class, 'key', 'project_key');
	}
}
