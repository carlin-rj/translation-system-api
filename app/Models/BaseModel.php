<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * @method static Builder|static filter($input = [], $filter = null)
 * @method static static|Builder create(array $attributes = [])
 * @method static static|Builder whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static static|Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @mixin IdeHelperBaseModel
 */
class BaseModel extends Model
{

}
