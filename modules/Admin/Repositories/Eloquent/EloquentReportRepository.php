<?php

namespace Modules\Admin\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\CourseRepository;
use Modules\Admin\Repositories\ReportRepository;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Question;
use Modules\Mon\Entities\QuestionGroup;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\UserLesson;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use PhpOffice\PhpSpreadsheet\Reader\Xls\Style\Border;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EloquentReportRepository extends BaseRepository implements ReportRepository
{
    public function exportGradeDetail(Request $request, Grade $grade)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->mergeCells("A1:E1");
        $sheet->getStyle("A1:G1")->getFont()->setSize(20);


        $sheet->setCellValue('A1', 'BÁO CÁO CHƯƠNG TRÌNH');
        $sheet->setCellValue('A4', 'Thông tin chương trình');
        $sheet->setCellValue('A5', 'Ngày');
        $sheet->setCellValue('B5', $grade->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
            $grade->start_time)->format('Y-m-d') : '');

        $sheet->setCellValue('A6', 'Địa điểm');
        $sheet->setCellValue('B6',
            $grade->place . ', ' . optional($grade->phoenix)->name . ', ' . optional($grade->district)->name . ', ' . optional($grade->province)->name);

        $sheet->setCellValue('A7', 'Thời lượng');
        $sheet->setCellValue('B7', $grade->hours);

        $sheet->setCellValue('A8', 'Giá trị');
        $sheet->setCellValue('B8', optional($grade->course)->tuition);

        $sheet->setCellValue('A9', 'Phân loại');
        $sheet->setCellValue('B9', optional($grade->course)->type);

        $sheet->setCellValue('A10', 'Khoá');
        $sheet->setCellValue('B10', optional($grade->course)->name);

        $sheet->setCellValue('A11', 'Lớp');
        $sheet->setCellValue('B11', $grade->name);

        $sheet->setCellValue('A12', 'Dự án thực hiện');
        $sheet->setCellValue('B12', optional($grade->course)->project);

        $sheet->setCellValue('A13', 'Giảng viên');
        $sheet->setCellValue('B13', $grade->teacher);

        $sheet->setCellValue('A13', 'Đối tượng tham dự');
        $sheet->setCellValue('B13', implode(",", optional($grade->course)->object));

        // grade review
        $groups = QuestionGroup::orderBy('order_')->get();
        $data = [];

        foreach ($groups as $group) {
            $row = [];
            $row['name'] = $group->title;
            $row['id'] = $group->id;
            $questions = Question::where('group_id', $group->id)->get();
            $questionRateData = [];

            foreach ($questions as $question) {
                if ($question->type == 'rate') {
                    $rateAvg = Review::where([
                        'grade_id' => $grade->id,
                        'question_id' => $question->id
                    ])->avg('answer');
                    $questionRateData[] = [$question->content, $rateAvg];
                } else {
                    $reviews = Review::where([
                        'grade_id' => $grade->id,
                        'question_id' => $question->id
                    ])->get();
                    $rowCell =  [$question->content];
                    foreach ($reviews as $review) {
                        $rowCell[] = $review->answer;
                    }
                    $questionRateData[] = $rowCell;
                }

            }
            if (count($questionRateData)) {
                $row['questions'] = $questionRateData;
                $data[] = $row;
            }

        }
        $startLine = 15;
        // end grade review
        foreach ($data as $group) {
            if ($group['id'] != 5) {
                $sheet->mergeCells("A$startLine:E$startLine");
                $sheet->setCellValue("A$startLine", $group['name']);
                $sheet->getStyle("A$startLine:G$startLine")->getFont()->setSize(14);
                $startLine++;

                $sheet->fromArray(
                    $group['questions'],   // The data to set
                    null,        // Array values with this value will not be set
                    "A$startLine"         // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
                );
                for ($i = 1; $i <= count($group['questions']); $i++) {
                    //$sheet->mergeCells("A$startLine:D$startLine");
                    $startLine++;

                }
            } else {
                $sheet->mergeCells("A$startLine:E$startLine");
                $sheet->setCellValue("A$startLine", $group['name']);
                $sheet->getStyle("A$startLine:G$startLine")->getFont()->setSize(14);
                $startLine++;
                $questionsOther = [];
                $answersOther = [];
                foreach ($group['questions'] as $questionTmp) {
                    $questionsOther[] = $questionTmp[0];
                    $answersOther[] = $questionTmp[1];
                }
                $sheet->fromArray(
                    [$questionsOther, $answersOther],   // The data to set
                    null,        // Array values with this value will not be set
                    "A$startLine"         // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
                );
                $startLine = $startLine + 2;
            }

        }


        $writer = new Xlsx($spreadsheet);
        $filename = 'app/exports/Summary report detail_' . time() . '.xlsx';
        $writer->save(storage_path($filename));
        return storage_path($filename);
    }

    public function exportReviewHistory(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->mergeCells("A1:L1");
        $sheet->getStyle("A1:G1")->getFont()->setSize(20);

        $sheet->setCellValue('A1', 'Personal assessment report');

        $sheet->mergeCells("A4:A5");
        $sheet->setCellValue('A4', 'Date');

        $sheet->mergeCells("B4:B5");
        $sheet->setCellValue('B4', 'Full name');

        $sheet->mergeCells("C4:C5");
        $sheet->setCellValue('C4', 'Address');

        $sheet->mergeCells("D4:D5");
        $sheet->setCellValue('D4', 'Course');

        $sheet->mergeCells("E4:E5");
        $sheet->setCellValue('E4', 'Class');

        $sheet->mergeCells("F4:F5");
        $sheet->setCellValue('F4', 'Lesson');

        // grade review
        $groups = QuestionGroup::orderBy('order_')->get();
        $data = [];
        $summaryRow = [];
        $countRow = [];

        $groupStartColumn = 71;
        $questionStartColumn = 71;
        foreach ($groups as $group) {
            $questions = $group->questions;
            $sheet->mergeCells(chr($groupStartColumn) . '4:' . chr($groupStartColumn + $questions->count() - 1) . '4');
            $sheet->setCellValue(chr($groupStartColumn) . '4', $group->title);
            foreach ($questions as $index => $question) {
                $sheet->setCellValue(chr($questionStartColumn) . '5', $question->content);
                $questionStartColumn++;
            }
            $groupStartColumn += $questions->count();
        }
        $startLine = 6;
        $reviewData = $this->getReviewHistoryData($request);

        foreach ($reviewData as $reviewLesson) {
            $questionStartColumn = 71;

            $reviews = Review::where([
                'reviews.user_id' => $reviewLesson->user_id,
                'reviews.lesson_id' => $reviewLesson->lesson_id,
            ])->get();


            $sheet->setCellValue("B$startLine", optional($reviewLesson->user)->name);
            $sheet->setCellValue("C$startLine", optional(optional($reviewLesson->lesson)->grade)->place.', '. optional(optional(optional($reviewLesson->lesson)->grade)->phoenix)->name.', '. optional(optional(optional($reviewLesson->lesson)->grade)->district)->name.', '. optional(optional(optional($reviewLesson->lesson)->grade)->province)->name);
            $sheet->setCellValue("D$startLine", optional(optional($reviewLesson->lesson)->course)->name);
            $sheet->setCellValue("E$startLine", optional(optional($reviewLesson->lesson)->grade)->name);
            $sheet->setCellValue("F$startLine", optional($reviewLesson->lesson)->name);
            foreach ($groups as $group) {
                $questions = $group->questions;

                foreach ($questions as $index => $question) {
                    if (!isset($summaryRow[$questionStartColumn])) {
                        $summaryRow[$questionStartColumn] = 0;
                        $countRow[$questionStartColumn] = 0;
                    }
                    $review = $reviews->firstWhere('question_id', $question->id);

                    $sheet->setCellValue("A$startLine", optional(optional($review)->created_at)->format('Y-m-d H:i'));
                    $sheet->setCellValue(chr($questionStartColumn) . $startLine, optional($review)->answer);
                    $summaryRow[$questionStartColumn] += (int)optional($review)->answer;
                    $countRow[$questionStartColumn] += 1;
                    $questionStartColumn++;
                }

            }
            $startLine++;
        }

        // summary
        $questionStartColumn = 71;
        $sheet->mergeCells('A' . $startLine . ':' . chr(70) . $startLine);
        $sheet->setCellValue('A' . $startLine, 'Điểm trung bình');
        $totalPoint = 0;
        $totalQuestion = 0;
        foreach ($groups as $group) {
            $questions = $group->questions;
            $totalGroup = 0;
            $totalGroupQuestion = 0;
            $groupColumn = $questionStartColumn;
            foreach ($questions as $index => $question) {
                if ($question->type == 'rate') {
                    $totalGroup += $summaryRow[$questionStartColumn];
                    $totalGroupQuestion += $countRow[$questionStartColumn];
                    $totalPoint += $summaryRow[$questionStartColumn];
                    $totalQuestion += $countRow[$questionStartColumn];
                } else {
                    $sheet->setCellValue(chr($questionStartColumn) . $startLine, '');
                }

                $questionStartColumn++;
            }
            if ($totalGroup > 0) {
                $sheet->setCellValue(chr($groupColumn) . $startLine, $totalGroupQuestion > 0 ? round($totalGroup / $totalGroupQuestion, 2) : 0);

            }

        }
        $sheet->setCellValue('A' . $startLine, 'Điểm trung bình tổng: ' . ($totalQuestion > 0 ? round($totalPoint / $totalQuestion, 2) : 0));
        $sheet->getStyle('A' . $startLine)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);


        $writer = new Xlsx($spreadsheet);
        $filename = 'app/exports/Personal assessment report.xlsx';
        $writer->save(storage_path($filename));
        return storage_path($filename);
    }

    public function getReviewHistoryData(Request $request)
    {
        $query = Review::with(['user', 'lesson']);
        $query->select('user_id', 'lesson_id')->distinct();

        if (!empty($request->get('username'))) {
            $keyword = $request->get('username');
            $query->whereHas('user', function ($q) use ($keyword) {

                $q->where('username', 'like', "%$keyword%");
            });
        }
        if (!empty($request->get('name'))) {
            $keyword = $request->get('name');
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%");
            });
        }
        if (!empty($request->get('email'))) {
            $keyword = $request->get('email');
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('email', 'like', "%$keyword%");
            });
        }
        if (!empty($request->get('phone'))) {
            $keyword = $request->get('phone');
            $query->whereHas('user.profile', function ($q) use ($keyword) {
                $q->where('phone', 'like', "%$keyword%");
            });
        }
        if (!empty($request->get('created_at'))) {
            $keyword = $request->get('created_at');
            $query->whereDate('created_at', $keyword);
        }
        if (!empty($request->get('course_id'))) {
            $keyword = $request->get('course_id');
            $query->where('course_id', $keyword);
        }
        if (!empty($request->get('grade_id'))) {
            $keyword = $request->get('grade_id');
            $query->where('grade_id', $keyword);
        }
        if (!empty($request->get('lesson_id'))) {
            $keyword = $request->get('lesson_id');
            $query->where('lesson_id', $keyword);
        }
        return $query->get();
    }
}
