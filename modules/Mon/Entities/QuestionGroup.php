<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\QuestionGroup
 *
 * @property int $id
 * @property string $title
 * @property int|null $order_
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\Question[] $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\QuestionGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionGroup extends Model
{


    protected $table = 'question_group';

    protected $fillable = ['title', 'order_'];
    public function questions() {
        return $this->hasMany(Question::class, 'group_id', 'id')->orderBy('order_', 'asc');
    }
}
