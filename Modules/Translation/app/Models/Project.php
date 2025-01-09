<?php

declare(strict_types=1);

namespace Modules\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Modules\Translation\Enums\TranslationStatusEnum;

/**
 * @mixin IdeHelperProject
 */
class Project extends Model
{
    use HasApiTokens;
    
	protected $guarded = [];

	/**
	 * 属性类型转换
	 */
	protected $casts = [
		'status' => 'integer',
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
	];


    //待翻译的翻译记录
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'project_key', 'key')->where('status', TranslationStatusEnum::WAITING);
    }

    //已翻译的翻译记录
    public function translatedTranslations(): HasMany
    {
        return $this->hasMany(Translation::class, 'project_key', 'key')->where('status', TranslationStatusEnum::COMPLETED);
    }
}
