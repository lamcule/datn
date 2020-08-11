<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\Review
 *
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property int $question_id
 * @property string $question_text
 * @property string|null $answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $course_id
 * @property int|null $grade_id
 * @property string|null $student_note
 * @property-read \Modules\Mon\Entities\Course|null $course
 * @property-read \Modules\Mon\Entities\Grade|null $grade
 * @property-read \Modules\Mon\Entities\Lesson $lesson
 * @property-read \Modules\Mon\Entities\Question $question
 * @property-read \Modules\Mon\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereQuestionText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereStudentNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Review whereUserId($value)
 * @mixin \Eloquent
 */
class Review extends Model
{

    protected $table = 'reviews';
    protected $fillable = ['user_id', 'lesson_id', 'course_id', 'grade_id', 'question_id', 'question_text', 'answer', 'student_note'];

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
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

}
