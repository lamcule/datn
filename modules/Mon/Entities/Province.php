<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\Province
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $type
 * @property string|null $phone_code
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province wherePhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\Province whereType($value)
 * @mixin \Eloquent
 */
class Province extends Model
{
    public $timestamps = false;
    protected $table = 'province';
    protected $fillable = ['name', 'code', 'type', 'phone_code'];
}
