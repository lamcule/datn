<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'admin__banner_translations';
}
