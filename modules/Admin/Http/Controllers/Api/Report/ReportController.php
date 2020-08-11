<?php

namespace Modules\Admin\Http\Controllers\Api\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Repositories\CourseRepository;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\ReviewRepository;
use Modules\Admin\Repositories\StudentRepository;
use Modules\Admin\Transformers\Province\ProvinceTransformer;
use Modules\Admin\Transformers\Report\ReportCourseActivityTransformer;
use Modules\Admin\Transformers\Report\ReportGradeDetailTransformer;
use Modules\Admin\Transformers\Report\ReportReviewHistoryTransformer;
use Modules\Admin\Transformers\Report\ReportStudentActivityTransformer;
use Modules\Admin\Transformers\Report\ReportStudentLessonTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Question;
use Modules\Mon\Entities\QuestionGroup;
use Modules\Mon\Entities\Review;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ReportController extends ApiController
{
    /**
     * @var CourseRepository
     */
    private $courseRepository;

    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var GradeRepository
     */
    private $gradeRepository;

    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    public function __construct(
        Authentication $auth,
        StudentRepository $studentRepository,
        GradeRepository $gradeRepository,
        ReviewRepository $reviewRepository,
        CourseRepository $courseRepository
    ) {
        parent::__construct($auth);

        $this->studentRepository = $studentRepository;
        $this->gradeRepository = $gradeRepository;
        $this->reviewRepository = $reviewRepository;
        $this->courseRepository = $courseRepository;
    }


    public function student(Request $request)
    {
        return StudentTransformer::collection($this->studentRepository->serverPagingForReport($request));
    }

    public function grades(Request $request)
    {
        return ReportGradeDetailTransformer::collection($this->gradeRepository->serverPagingFor($request));
    }

    public function gradeDetail(Request $request, Grade $grade)
    {
        return new ReportGradeDetailTransformer($grade);
    }
    public function sumRateByGrade(Request $request, Grade $grade)
    {
        $groups = QuestionGroup::orderBy('order_')->get();
        $data=[];

        foreach ($groups as $group) {
            $row = [];
            $row['name'] = $group->title;
            $row['id'] = $group->id;
            $questions = Question::where('group_id', $group->id)->get();
            $questionRateData=[];

            foreach ($questions as $question) {
                if ($question->type == 'rate') {
                    $rateAvg = Review::where([
                        'grade_id'=> $grade->id,
                        'question_id' => $question->id
                    ])->avg('answer');
                    $questionRateData[] =[
                        'id' => $question->id,
                        'question' => $question->content,
                        'rate_avg' => $rateAvg
                    ];
                }

            }
            if (count($questionRateData)) {
                $row['questions'] = $questionRateData;
                $data[] = $row;
            }

        }
        return $data;
    }
    public function gradeReviewDetail(Request $request, Grade $grade) {
        $reviews = $this->reviewRepository->reviewForGrade($request,$grade);
        $numberCmtQuestions = Question::where('type','text')->get();
        return [
            'data' => $reviews,
            'count_question' => $numberCmtQuestions
        ];

    }
    public function studentActivity(Request $request)
    {
        return ReportStudentActivityTransformer::collection($this->gradeRepository->getStudentActivity($request));

    }
    public function reviewHistory(Request $request)
    {
        return ReportReviewHistoryTransformer::collection($this->reviewRepository->getUserReviewHistory($request));

    }
	public function studentLesson(Request $request)
	{
		return ReportStudentLessonTransformer::collection($this->studentRepository->getStudentLessonReport($request));

	}
	public function courseActivity(Request $request)
	{
		return ReportCourseActivityTransformer::collection($this->gradeRepository->getStudentActivity($request));

	}
}
