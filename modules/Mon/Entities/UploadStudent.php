<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\UploadStudent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UploadStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UploadStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UploadStudent query()
 * @mixin \Eloquent
 */
class UploadStudent extends Model
{

    protected $table = 'admin__uploadstudents';
    public $translatedAttributes = [];
    protected $fillable = [];
}
