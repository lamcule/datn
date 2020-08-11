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
use Modules\Admin\Transformers\Profile\ProfileTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\User;
use Modules\Mon\Entities\UserLesson;

class StudentActivityExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
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
            'Project',
            'Trainer/Expert',
            'Check in',
            'Check out',
            'Feedback (on a 5-point scale)',

        ];
    }
    /**
     * @var Grade $grade
     */
    public function map($grade): array
    {
        $total_user_lesson = UserLesson::where('grade_id', $grade->id)->count();
        $course = Course::query()->withTrashed()->find($grade->course_id);
        return [
            $grade->created_at->format('Y-m-d'),
            optional($course)->area,
            $grade->name,
            optional($course)->name,
            optional($course)->project,
            $grade->teacher,
            $grade->number_checkin.'/'.$total_user_lesson,
            $grade->number_checkout.'/'.$total_user_lesson,
            $grade->rate_avg,

        ];
    }
}
