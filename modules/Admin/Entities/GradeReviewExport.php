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
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Excel;
use Modules\Admin\Repositories\ReviewRepository;
use Modules\Mon\Entities\Grade;

class GradeReviewExport implements FromArray, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public $data;
    public $numberCmtQuestions;

    public function __construct($data, $numberCmtQuestions)
    {
        $this->data = $data;
        $this->numberCmtQuestions = $numberCmtQuestions;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        $heading = [
            'Mã học viên',
            'Tên học viên',
            'Khóa',
            'Lớp',
            'Buổi',


        ];
        for ($i = 0; $i< $this->numberCmtQuestions; $i++) {
            $heading[] = 'Câu hỏi '.($i+1);
            $heading[] = 'Câu trả lời '.($i+1);
        }
        return $heading;
    }


    public function map($row): array
    {
        $output =  [

            $row['username'],
            $row['user'],
            $row['course'],
            $row['grade'],
            $row['lesson'],

        ];
        if (isset($row['reviews']) && is_array($row['reviews'])) {
            foreach ($row['reviews'] as $review) {
                $output[] = $review['question'];
                $output[] = $review['answer'];
            }
        }
        return $output;
    }


}
