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
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\User;

class CourseExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
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
        $query = Course::query()->with('user');
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%");
            });
        }
        if ($request->has('status') && !empty($request->get('status'))) {
            $status = $request->get('status');
            $query->where('status', $status);
        }
        if ($request->get('type') !== null) {
            $type = $request->get('type');
            $query->where('type', 'LIKE', "%{$type}%");
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
            'Description',
            'Creation time',
	        'Activity type',
	        'Area',
	        'Role',
	        'Frequency',
	        'Project',
	        'Scale',
	        'Target',
	        'Status',
	        'Creator',
        ];
    }
    /**
     * @var Course $course
     */
    public function map($course): array
    {
        return [
	        $course->code,
	        $course->name,
	        $course->description,
            optional($course->created_at)->format('d-m-Y'),


	        $course->type,
	        $course->area,
	        $course->role,
	        $course->frequency,
	        $course->project,
	        $course->scale,
	        $course->object,
	        $course->status,
            optional($course->user)->username,


        ];
    }
}
