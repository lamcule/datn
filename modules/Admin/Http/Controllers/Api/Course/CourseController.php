<?php

namespace Modules\Admin\Http\Controllers\Api\Course;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Repositories\LessonRepository;
use Modules\Admin\Transformers\Course\CourseFullTransformer;
use Modules\Admin\Transformers\Course\CourseTransformer;
use Modules\Mon\Entities\Course;
use Modules\Admin\Http\Requests\Course\CreateCourseRequest;
use Modules\Admin\Http\Requests\Course\UpdateCourseRequest;
use Modules\Admin\Repositories\CourseRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class CourseController extends ApiController
{
    /**
     * @var CourseRepository
     */
    private $courseRepository;
    private $gradeRepository;
    private $lessonRepository;

    public function __construct(Authentication $auth, CourseRepository $course,
                                GradeRepository $grade, LessonRepository $lesson)
    {
        parent::__construct($auth);

        $this->courseRepository = $course;
        $this->gradeRepository = $grade;
        $this->lessonRepository = $lesson;
    }


    public function index(Request $request)
    {
        return CourseTransformer::collection($this->courseRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return CourseTransformer::collection($this->courseRepository->getAll($request));
    }


    public function store(CreateCourseRequest $request)
    {
        $user_id = \Auth::id();
        $data = $request->all();
        $data['created_by'] = $user_id;
        $this->courseRepository->create($data);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::course.message.create success'),
        ]);
    }


    public function find(Course $course)
    {
        return new  CourseFullTransformer($course);
    }

    public function update(Course $course, UpdateCourseRequest $request)
    {
        $this->courseRepository->update($course, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::course.message.update success'),
        ]);
    }

    public function destroy(Course $course)
    {
        try {
            DB::beginTransaction();
            $this->courseRepository->destroy($course);

            $grades = $this->gradeRepository->newQueryBuilder()
                ->select('id')
                ->where('course_id', $course->id)->get();
            $this->gradeRepository->deleteMultiRecord($grades->toArray());

            $lessons = $this->lessonRepository->newQueryBuilder()
                ->select('id')
                ->where('course_id', $course->id)->get();
            $this->lessonRepository->deleteMultiRecord($lessons->toArray());

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'errors' => false,
            'message' => trans('backend::course.message.delete success'),
        ]);
    }

    public function getProvinces()
    {
        $province = Province::all();
        return response()->json($province);
    }

    public function getActiveCourse(Request $request)
    {
        return CourseTransformer::collection($this->courseRepository->getActiveCourse($request));
    }
}
