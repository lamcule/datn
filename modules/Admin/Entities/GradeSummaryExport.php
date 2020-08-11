<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/10/19
 * Time: 1:10 PM
 */

namespace Modules\Admin\Entities;


use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Excel;
use Modules\Mon\Entities\Grade;

class GradeSummaryExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;



    public function __construct()
    {

    }

    public function query()
    {
        $query = Grade::query()->with(['users', 'course',   'lessons',  'phoenix','district','province']);

        return $query;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Month',
            'Year',
            'Course',
            'Activity type',
            'Address',
            'Project',
            'Beneficiaries',
            'Class',
            'Duration',
            'Scale',
            'Trainer/Expert',
            'Description'

        ];
    }

    /**
     * @var Grade $grade
     */
    public function map($grade): array
    {
        return [

            $grade->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
                $grade->start_time)->format('d') : '',
            $grade->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
                $grade->start_time)->format('m') : '',
            $grade->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
                $grade->start_time)->format('Y') : '',
            $grade->course->name,
            $grade->course->type,
            $grade->place.', '. optional($grade->phoenix)->name.', '. optional($grade->district)->name.', '. optional($grade->province)->name,
            $grade->course->project,
            $grade->course->object? implode(',',$grade->course->object):'',
            $grade->name,
            $grade->hours,
            $grade->users()->count(),
            $grade->teacher,
            $grade->course->description
        ];
    }


}
