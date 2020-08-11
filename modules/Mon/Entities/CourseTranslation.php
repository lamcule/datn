<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Admin\Entities\CourseTranslation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Entities\CourseTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Entities\CourseTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Entities\CourseTranslation query()
 * @mixin \Eloquent
 */
class CourseTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'admin__course_translations';
}
