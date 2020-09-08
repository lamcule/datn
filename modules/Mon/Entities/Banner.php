<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $table = 'banner';
    public $translatedAttributes = [];
    protected $fillable = [
        'title',
        'image',
        'link',
        'position',
        'status',
        'created_at',
        'updated_at'
    ];
}
