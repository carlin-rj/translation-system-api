<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperDataCollectVideos
 */
class DataCollectVideos extends Model
{
    use HasFactory;

    protected $table = 'data_collect_videos';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'data'=>'json',
        ];
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function videoItems(): HasMany
    {
        return $this->hasMany(DataCollectVideoItems::class, 'video_id', 'id');
    }
}
