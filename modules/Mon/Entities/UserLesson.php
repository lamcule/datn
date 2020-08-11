<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\UserLesson
 *
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property int|null $course_id
 * @property int|null $grade_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $checkin_at
 * @property \Illuminate\Support\Carbon|null $checkout_at
 * @property-read \Modules\Mon\Entities\Course|null $course
 * @property-read \Modules\Mon\Entities\Grade|null $grade
 * @property-read \Modules\Mon\Entities\Lesson $lesson
 * @property-read \Modules\Mon\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereCheckinAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereCheckoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserLesson whereUserId($value)
 * @mixin \Eloquent
 */
class UserLesson extends Model
{

    protected $casts = [

        'checkin_at' => 'datetime',
        'checkout_at' => 'datetime',
    ];
    protected $table = 'user_lesson';

    protected $fillable = ['user_id','lesson_id','course_id','grade_id','checkin_at', 'checkout_at'];
    public function user() {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    public function course() {
        return $this->belongsTo(Course::class,'course_id', 'id');
    }
    public function grade() {
        return $this->belongsTo(Grade::class,'grade_id', 'id');
    }
    public function lesson() {
        return $this->belongsTo(Lesson::class,'lesson_id', 'id');
    }
}
