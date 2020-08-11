<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Modules\Mon\Entities\StudentImport
 *
 * @property int $id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string $status
 * @property string $path
 * @property int|null $records
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Mon\Entities\ImportDetail[] $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereRecords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\StudentImport whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class StudentImport extends Model
{
    const STATUS_UPLOADED = 'Uploaded';
    const STATUS_IMPORTED = 'Imported';
    use Userstamps;
    protected $table = 'student_import';

    protected $fillable = ['status','path','records','created_by','updated_by','deleted_by'];

    public function details() {
        return $this->hasMany(ImportDetail::class, 'import_id', 'id');
    }
}
