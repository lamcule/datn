<?php

namespace Modules\Admin\Http\Controllers\Admin\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Entities\CourseActivityExport;
use Modules\Admin\Entities\GradeReviewExport;
use Modules\Admin\Entities\GradeSummaryExport;
use Modules\Admin\Entities\StudentActivityExport;
use Modules\Admin\Entities\StudentExport;
use Modules\Admin\Entities\StudentLessonExport;
use Modules\Admin\Repositories\ReportRepository;
use Modules\Admin\Repositories\ReviewRepository;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Question;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    /**
     * @var ReportRepository
     */
    private $reportRepository;

    public function __construct(

        ReviewRepository $reviewRepository,
        ReportRepository $reportRepository
    ) {

        $this->reviewRepository = $reviewRepository;
        $this->reportRepository = $reportRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function student()
    {

        return view('admin::reports.index');
    }
    public function downloadStudent(Request $request)
    {

        return (new StudentExport($request))->download('Participant list.xlsx');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function teacher()
    {

        return view('admin::reports.index');
    }
    public function downloadTeacher(Request $request)
    {

        return (new StudentExport($request))->download('Participant list.xlsx');

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function grades()
    {

        return view('admin::reports.grades');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function grade()
    {

        return view('admin::reports.grade');
    }
    public function downloadGradeSummary()
    {

        return (new GradeSummaryExport())->download('Summary report.xlsx');

    }
    public function downloadGradeReview(Request $request, Grade $grade)
    {
        $reviews = $this->reviewRepository->reviewForGrade($request,$grade);
        $numberCmtQuestions = Question::where('type','text')->count();
        return (new GradeReviewExport($reviews, $numberCmtQuestions))->download('class_review.xlsx');

    }

    public function studentActivity()
    {

        return view('admin::reports.index');
    }
    public function downloadStudentActivity(Request $request)
    {

        return (new StudentActivityExport($request))->download('Course report.xlsx');

    }

    public function reviewHistory()
    {

        return view('admin::reports.index');
    }
    public function downloadReviewHistory(Request $request)
    {

        return   response()->download($this->reportRepository->exportReviewHistory($request));

    }
    public function downloadGradeDetail(Request $request, Grade $grade)
    {
        return   response()->download($this->reportRepository->exportGradeDetail($request, $grade));
    }

	public function studentLesson()
	{

		return view('admin::reports.index');
	}
	public function downloadStudentLesson(Request $request)
	{

		return (new StudentLessonExport($request))->download('Course feedback report.xlsx');

	}
	public function courseActivity()
	{

		return view('admin::reports.index');
	}
	public function downloadCourseActivity(Request $request)
	{

		return (new CourseActivityExport($request))->download('Activity report.xlsx');

	}
}
