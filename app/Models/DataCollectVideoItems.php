<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperDataCollectVideoItems
 */
class DataCollectVideoItems extends Model
{
    use HasFactory;

    protected $table = 'data_collect_video_items';

    protected $guarded = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
