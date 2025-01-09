<?php

namespace Modules\Translation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperTranslations
 */
class Translations extends Model
{
    use HasFactory;

    protected $table = 'tm_translations';

    protected $guarded = [];

    public function language(): HasOne
    {
       return $this->hasOne(Language::class, 'code', 'language');
    }

}
