<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/10/19
 * Time: 1:10 PM
 */

namespace Modules\Admin\Entities;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Admin\Transformers\Profile\ProfileTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\User;

class GradeExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $request = $this->request;
        $query = Grade::query()
            ->with(['course','province', 'district', 'phoenix']);
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
	        $query->where(function ($q) use ($keyword) {
		        $q->where('name', 'LIKE', "%{$keyword}%")
			        ->orWhere('id', 'LIKE', "%{$keyword}%")
			        ->orWhere('place', 'LIKE', "%{$keyword}%");
	        });
        }
	    if ($request->has('status') && !empty($request->get('status'))) {
		    $status = $request->get('status');
		    $query->where('status', $status);
	    }
	    if ($request->get('course') !== null) {
		    $course_id = $request->get('course');
		    $query->where('course_id', 'LIKE', "%{$course_id}%");
	    }

	    if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
		    $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

		    $query->orderBy($request->get('order_by'), $order);
	    } else {
		    $query->orderBy('created_at', 'desc');
	    }
        return $query;
    }
    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Address',
            'Status',
	        'Ward',
	        'District',
	        'Province/City',
	        'Start time',
	        'Teacher',
	        'Teacher type',
	        'Teacher organization',
        ];
    }
    /**
     * @var Grade $grade
     */
    public function map($grade): array
    {
        return [
	        $grade->code,
	        $grade->name,
	        $grade->place,
	        $grade->status,
	        optional($grade->phoenix)->name,
	        optional($grade->district)->name,
	        optional($grade->province)->name,

	        $grade->start_time,
	        $grade->teacher,
	        $grade->teacher_type,
	        $grade->teacher_company,


        ];
    }
}
