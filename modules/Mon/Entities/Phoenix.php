<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\Phoenix
 *
 * @property int $id
 * @property string $name
 * @property int $district_id
 * @property string|null $code
 * @property string|null $type
 * @property-read \Modules\Mon\Entities\District $district
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Phoenix whereType($value)
 * @mixin \Eloquent
 */
class Phoenix extends Model
{
    public $timestamps = false;
    protected $table = 'phoenix';
    protected $fillable = ['name', 'code', 'type', 'district_id',];
    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
