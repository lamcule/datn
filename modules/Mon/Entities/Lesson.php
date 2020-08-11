<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Traits\MediaRelation;

/**
 * Modules\Mon\Entities\Lesson
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $topic
 * @property int|null $grade_id
 * @property array|null $target
 * @property array|null $content
 * @property string|null $duration
 * @property string|null $document
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $place
 * @property int|null $course_id
 * @property int|null $province_id
 * @property int|null $district_id
 * @property int|null $phoenix_id
 * @property string|null $teacher
 * @property-read \Modules\Mon\Entities\Course|null $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Media\Entities\Media[] $files
 * @property-read int|null $files_count
 * @property-read mixed $lesson_document
 * @property-read \Modules\Mon\Entities\Grade|null $grade
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Lesson onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson wherePhoenixId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Lesson withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Lesson withoutTrashed()
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use SoftDeletes, MediaRelation;
    const STATUS_NOT_START = "Not happening yet";
    const STATUS_STARTED = "Happenning";
    const STATUS_FINISHED = "Took place";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
        'target' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    protected $table = 'lessons';
    public $translatedAttributes = [];
    protected $fillable = [
        'name',
        'topic',
        'grade_id',
        'target',
        'content',
        'duration',
        'document',
        'status',
        'start_time',
        'end_time',
        'place',
        'course_id',
        'province_id',
        'district_id',
        'phoenix_id',
        'teacher'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function users() {
        return $this->belongsToMany(User::class, 'user_lesson', 'lesson_id', 'user_id')->withPivot('checkin_at', 'checkout_at');
    }

    public function getStatusClass() {
        $classCode = '';
        switch ($this->status) {
            case self::STATUS_NOT_START:
                $classCode =  "bg-olive";
                break;
            case self::STATUS_STARTED:
                $classCode =  "bg-fuchsia";
                break;
            default:
                $classCode =  "bg-maroon";
                break;
        }
        return $classCode;
    }
    public function getQRTypeClass($type) {
        $classCode = '';
        switch ($type) {
            case 'Review':
                $classCode =  "bg-orange";
                break;
            case 'Check-in':
                $classCode =  "bg-maroon";
                break;
            default:
                $classCode =  "bg-purple";
                break;
        }
        return $classCode;
    }
    public function getLessonDocumentAttribute()
    {
        return $this->filesByZone('lesson_document')->get();
    }
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
}
