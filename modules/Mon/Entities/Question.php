<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\Question
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property int|null $order_
 * @property int|null $group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['content','type','order_', 'group_id'];
}
