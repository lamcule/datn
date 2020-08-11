<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Media\Traits\MediaRelation;
use Spatie\Permission\Traits\HasRoles;
use Wildside\Userstamps\Userstamps;

/**
 * Modules\Mon\Entities\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $activated
 * @property string|null $last_login
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $username
 * @property string|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\Course[] $courses
 * @property-read int|null $courses_count
 * @property-read \Modules\Mon\Entities\User|null $createdBy
 * @property-read \Modules\Mon\Entities\User|null $deletedBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\Grade[] $grades
 * @property-read int|null $grades_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\Lesson[] $lessons
 * @property-read int|null $lessons_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Modules\Mon\Entities\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\UserToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Modules\Mon\Entities\User|null $updatedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereActivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, SoftDeletes, Userstamps, MediaRelation;

    const TYPE_ADMIN = 'admin';
    const TYPE_STUDENT = 'student';
    const TYPE_TEACHER = 'teacher';

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'activated',
        'last_login',
        'username',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tokens()
    {
        return $this->hasMany(UserToken::class, 'user_id', 'id');
    }

    /**
     * Lấy thông tin profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }


    public function getFirstToken()
    {
        return $this->tokens()->first();
    }

    public function getFirstTokenKey()
    {
        $userToken = $this->tokens()->first();

        if ($userToken === null) {
            return '';
        }

        return $userToken->access_token;
    }
    /**
     * Get the user that created the model.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    /**
     * Get the user that updated the model.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    /**
     * Get the user that deleted the model.
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
    public function courses() {
        return $this->belongsToMany(Course::class, 'user_grade', 'user_id', 'course_id');
    }
    public function grades() {
        return $this->belongsToMany(Grade::class, 'user_grade', 'user_id', 'grade_id');
    }
    public function lessons() {
        return $this->belongsToMany(Lesson::class, 'user_lesson', 'user_id', 'lesson_id')
            ->withPivot(['checkin_at','checkout_at']);
    }
    public function reviews() {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function getUserPhotoAttribute()
    {
        return $this->filesByZone('user_photo')->get();
    }
}
