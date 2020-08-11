<?php

namespace Modules\Mon\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

/**
 * Modules\Mon\Entities\ImportDetail
 *
 * @property int $id
 * @property int $import_id
 * @property array $content
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $imported_at
 * @property array|null $imported_description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereImportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereImportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereImportedDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\ImportDetail whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class ImportDetail extends Model
{
    const STATUS_UPLOADED = 'Uploaded';
    const STATUS_IMPORTED = 'Imported';
    const STATUS_ERROR = 'Error';

    use Userstamps;
    protected $casts = [
        'content' => 'array',
        'imported_description' => 'array',
        'imported_at' => 'datetime',
    ];
    protected $table = 'import_detail';

    protected $fillable = [
        'import_id',
        'content',
        'status',
        'imported_at',
        'imported_description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
