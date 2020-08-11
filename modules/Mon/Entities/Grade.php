<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Mon\Entities\Grade
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $number_of_lesson
 * @property int|null $course_id
 * @property string|null $place
 * @property string|null $teacher
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $province_id
 * @property int|null $district_id
 * @property int|null $phoenix_id
 * @property string|null $code
 * @property string|null $start_time
 * @property-read \Modules\Mon\Entities\Course|null $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\Lesson[] $lessons
 * @property-read int|null $lessons_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Grade onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereNumberOfLesson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade wherePhoenixId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Grade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Grade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Grade withoutTrashed()
 * @mixin \Eloquent
 */
class Grade extends Model
{
    use SoftDeletes;

    protected $table = 'grades';
    public $translatedAttributes = [];
    protected $fillable = [
        'name',
        'course_id',
        'number_of_lesson',
        'place',
        'teacher',
        'status',
        'province_id',
        'district_id',
        'phoenix_id',
        'code',
        'start_time',
        'teacher_type',
        'teacher_company',
        'hours',
        'end_time',
    ];
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id')->withDefault(['name'=>'']);
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id')->withDefault(['name'=>'']);
    }
    public function phoenix()
    {
        return $this->belongsTo(Phoenix::class, 'phoenix_id', 'id')->withDefault(['name'=>'']);
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'grade_id', 'id');
    }
    public function users() {
        return $this->belongsToMany(User::class, 'user_grade', 'grade_id', 'user_id');
    }
}
