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
use Modules\Admin\Repositories\CourseRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\StudentRepository;
use Modules\Admin\Transformers\Profile\ProfileTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\User;
use Modules\Mon\Entities\UserLesson;

class StudentLessonExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize {
	use Exportable;
	public $request;
	public $address;

	public function __construct(Request $request) {
	    $this->address = '';
		$this->request = $request;
        $lesson = Lesson::query()->where('id', $this->request->get('lesson_id'))->first();
	    if ($lesson) {
            $grade = $lesson->grade;
            $this->address =$grade->place.', '. optional($grade->phoenix)->name.', '. optional($grade->district)->name.', '. optional($grade->province)->name;
        }
	}

	public function query() {
		$repository = app(StudentRepository::class);
		return $repository->getStudentLessonReportQuery($this->request);
	}

	public function headings(): array {
		return [
			'User ID',

			'Full name',
			'Date of birth',
			'Sex',
			'Address',
			'Email',
			'Mobile phone',
			'Registration date',
			'Company',
			'Work area',
			'Organization group',
			'Individual group',
			'Checkin',
			'Checkout',
			'Feedback (on a 5-point scale)',


		];
	}

	/**
	 * @var User $user
	 */
	public function map($user): array {


		return [
			$user->username,
			$user->name,
            optional(optional($user->profile)->birth_date)->format('Y-m-d'),
			optional($user->profile)->gender,
            $this->address,
			$user->email,
			optional($user->profile)->phone,
			$user->created_at,
			optional($user->profile)->company,
			optional($user->profile)->company_address,
			optional($user->profile)->categories,
			optional($user->profile)->personal_categories,
			$user->checkin_at,
			$user->checkout_at,
			$user->feedback,

		];
	}
}
