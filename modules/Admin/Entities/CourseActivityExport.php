<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/10/19
 * Time: 1:10 PM
 */

namespace Modules\Admin\Entities;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Admin\Repositories\CourseRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Transformers\Profile\ProfileTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\User;
use Modules\Mon\Entities\UserGrade;
use Modules\Mon\Entities\UserLesson;

class CourseActivityExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $repository = app(GradeRepository::class);
        return $repository->getStudentActivityQuery($this->request);
    }
    public function headings(): array
    {
        return [
            'Date',
            'Address',
            'Course',
            'Class',
	        'Activity type',
	        'Role',
            'Project',
	        'Beneficiaries',
	        'Start time',
	        'Finish time',
	        'Duration',

            'Trainer/Expert',
	        'Description',
	        'The number of registered participant',
	        'The number of actual participant',
            'Check in',
            'Check out',
	        'The number of feedback collected',
            'Feedback (on a 5-point scale)',

        ];
    }
    /**
     * @var Grade $grade
     */
    public function map($grade): array
    {
        $total_user_lesson = UserGrade::where('grade_id', $grade->id)->count();
        $review_count = Review::where('grade_id', $grade->id)->select(['user_id'])->distinct()->count();
//        $lessons = Lesson::where('grade_id', $grade->id)->get();
        $hours = 0;
//        foreach ($lessons as $lesson) {
//        	if ($lesson->start_time && $lesson->end_time) {
//		        $start_time = \Carbon\Carbon::parse($lesson->start_time);
//		        $finish_time = \Carbon\Carbon::parse($lesson->end_time);
//		        $hours += $start_time->diffInHours($finish_time);
//
//
//	        }else {
//        		$hours +=1;
//	        }
//        }

        return [
            $grade->created_at->format('Y-m-d'),
            $grade->place.', '. optional($grade->phoenix)->name.', '. optional($grade->district)->name.', '. optional($grade->province)->name,

            optional($grade->course)->name,
	        $grade->name,
	        optional($grade->course)->type,
	        optional($grade->course)->role,
	        optional($grade->course)->project,
	        optional($grade->course)->object,
	        $grade->start_time ,
            $grade->end_time ,
            $grade->hours,
            $grade->teacher,
	        optional($grade->course)->description,
	        $total_user_lesson,
	        $grade->number_checkin,
            $grade->number_checkin.'/'.$total_user_lesson,
            $grade->number_checkout.'/'.$total_user_lesson,
	        ceil($review_count/16),
            $grade->rate_avg,

        ];
    }
}
