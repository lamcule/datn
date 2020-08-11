<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Mon\Entities\Course
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $type
 * @property string|null $description
 * @property string|null $area
 * @property string|null $role
 * @property string|null $frequency
 * @property string|null $project
 * @property string|null $scale
 * @property array|null $object
 * @property string|null $teacher
 * @property float|null $tuition
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property bool|null $has_notification
 * @property string|null $code
 * @property-read \Modules\Mon\Entities\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereHasNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereTuition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Course withoutTrashed()
 * @mixin \Eloquent
 */
class Course extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'object' => 'array',
        'has_notification' => 'boolean',
        'has_email' => 'boolean',

    ];
    use SoftDeletes;
    protected $table = 'courses';
    protected $fillable = [
        'name',
        'type',
        'description',
        'area',
        'role',
        'frequency',
        'project',
        'scale',
        'object',
        'teacher',
        'tuition',
        'status',
        'created_by',
        'created_at',
        'updated_at',
        'has_notification',
        'has_email',
        'code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
