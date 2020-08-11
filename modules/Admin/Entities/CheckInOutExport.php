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
use Modules\Admin\Repositories\UserLessonRepository;
use Modules\Mon\Entities\UserLesson;

class CheckInOutExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        /**
         * @var $repository UserLessonRepository
         */
        $repository = app(UserLessonRepository::class);
        return $repository->getCheckinoutQuery($this->request);
    }

    public function headings(): array
    {
        return [
            'Khoá học',
            'Lớp học',
            'Buổi học',
            'Học viên',
            'Thời gian check-in',
            'Thời gian checkout'
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
            optional($userlesson->checkin_at)->format('Y-m-d H:i:s'),
            optional($userlesson->checkout_at)->format('Y-m-d H:i:s'),

        ];
    }
}
