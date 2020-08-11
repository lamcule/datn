<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/10/19
 * Time: 1:10 PM
 */

namespace Modules\Admin\Entities;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Admin\Transformers\Profile\ProfileTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\User;
use Modules\Mon\Entities\UserLesson;
use Modules\Mon\Entities\UserReview;

class ReviewExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public $course_id;
    public $grade_id;
    public $lesson_id;

    public function __construct($course_id, $grade_id, $lesson_id)
    {
        $this->course_id = $course_id;
        $this->grade_id = $grade_id;
        $this->lesson_id = $lesson_id;
    }

    public function query()
    {
        $query = UserReview::query()->with(['user', 'course', 'grade', 'lesson', 'user.profile']);
        if (!empty($this->course_id)) {
            $query->where('course_id',$this->course_id);
        }
        if (!empty($this->grade_id)) {
            $query->where('grade_id',$this->grade_id);
        }
        if (!empty($this->lesson_id)) {
            $query->where('lesson_id',$this->lesson_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Khoá học',
            'Lớp học',
            'Buổi học',
            'Học viên',
            'Thời gian',

        ];
    }

    /**
     * @var UserLesson $userlesson
     */
    public function map($userlesson): array
    {
        return [

            optional($userlesson->course)->name,
            optional($userlesson->grade)->name,
            optional($userlesson->lesson)->name,
            optional($userlesson->user->profile)->full_name,
            optional($userlesson->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
