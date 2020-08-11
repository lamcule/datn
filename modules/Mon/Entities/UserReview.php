<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\UserReview
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $grade_id
 * @property int $lesson_id
 * @property string|null $student_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Mon\Entities\Course $course
 * @property-read \Modules\Mon\Entities\Grade $grade
 * @property-read \Modules\Mon\Entities\Lesson $lesson
 * @property-read \Modules\Mon\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereStudentNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserReview whereUserId($value)
 * @mixin \Eloquent
 */
class UserReview extends Model
{

    protected $table = 'user_reviews';

    protected $fillable = ['user_id', 'lesson_id', 'course_id', 'grade_id',  'student_note'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }
}
