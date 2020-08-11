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
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\User;

class LessonExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize {
	use Exportable;
	public $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

	public function query() {
		$request = $this->request;
		$query = Lesson::query()->with([ 'province', 'district', 'phoenix' ]);

		if ($request->get('search') !== null) {
			$keyword = $request->get('search');
			$query->where(function ($q) use ($keyword) {
				$q->where('name', 'LIKE', "%{$keyword}%")
					->orWhere('id', 'LIKE', "%{$keyword}%");
			});
		}
		if ($request->get('grade') !== null) {
			$grade_id = $request->get('grade');
			$query->where('grade_id', 'LIKE', "%{$grade_id}%");
		}
		if ($request->get('grade_id') !== null) {
			$grade_id = $request->get('grade_id');
			$query->where('grade_id', $grade_id);
		}
		if ($request->get('course_id') !== null) {
			$course_id = $request->get('course_id');
			$query->where('course_id', $course_id);
		}

		if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
			$order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

			$query->orderBy($request->get('order_by'), $order);
		} else {
			$query->orderBy('created_at', 'desc');
		}
		return $query;
	}

	public function headings(): array {
		return [
			'Name',
			'Address',
			'Topic',
			'Teacher',
			'Ward',
			'District',
			'Province/City',
			'Start time',
			'Finish time',
		];
	}

	/**
	 * @var Lesson $lesson
	 */
	public function map($lesson): array {
		return [
			$lesson->name,
			$lesson->place,
			$lesson->topic,
			$lesson->teacher,
			optional($lesson->phoenix)->name,
			optional($lesson->district)->name,
			optional($lesson->province)->name,

			$lesson->start_time,
			$lesson->end_time,


		];
	}
}
