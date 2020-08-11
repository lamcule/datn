<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\Mon\Entities\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $photo
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $company
 * @property string|null $company_address
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $categories
 * @property array|null $personal_categories
 * @property int|null $province_id
 * @property int|null $district_id
 * @property int|null $phoenix_id
 * @property string|null $full_name
 * @property string|null $position
 * @property-read \Modules\Mon\Entities\District|null $district
 * @property-read \Modules\Mon\Entities\Phoenix|null $phoenix
 * @property-read \Modules\Mon\Entities\Province|null $province
 * @property-read \Modules\Mon\Entities\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Profile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereCompanyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile wherePersonalCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile wherePhoenixId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Profile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Profile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Modules\Mon\Entities\Profile withoutTrashed()
 * @mixin \Eloquent
 */
class Profile extends Model
{
    use SoftDeletes;
    protected $dates = [
        'birth_date',
    ];
    protected $casts = [
        'categories' => 'array',
        'personal_categories' => 'array',

    ];
    protected $fillable = ['user_id', 'gender', 'birth_date', 'photo', 'phone', 'full_name', 'first_name', 'middle_name',
        'last_name', 'address', 'company','company_address', 'categories','personal_categories','position',
        'province_id','district_id', 'phoenix_id', 'source', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function phoenix()
    {
        return $this->belongsTo(Phoenix::class, 'phoenix_id', 'id');
    }
}
