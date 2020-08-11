<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\District
 *
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $code
 * @property string|null $type
 * @property-read \Modules\Mon\Entities\Province $province
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\District whereType($value)
 * @mixin \Eloquent
 */
class District extends Model
{
    public $timestamps = false;
    protected $table = 'district';


    protected $fillable = ['name', 'code', 'type', 'province_id', 'lat', 'lng'];
    public function province() {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
