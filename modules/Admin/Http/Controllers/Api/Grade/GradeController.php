<?php

namespace Modules\Admin\Http\Controllers\Api\Grade;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Events\GradeCreated;
use Modules\Admin\Repositories\LessonRepository;
use Modules\Admin\Transformers\Grade\GradeFullTransformer;
use Modules\Admin\Transformers\Grade\GradeTransformer;
use Modules\Admin\Transformers\Student\StudentFullTransformer;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Mon\Entities\Grade;
use Modules\Admin\Http\Requests\Grade\CreateGradeRequest;
use Modules\Admin\Http\Requests\Grade\UpdateGradeRequest;
use Modules\Admin\Repositories\GradeRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class GradeController extends ApiController
{
    /**
     * @var GradeRepository
     */
    private $gradeRepository;

    /**
     * @var LessonRepository
     */
    private $lessonRepository;

    public function __construct(Authentication $auth, GradeRepository $grade, LessonRepository $lesson)
    {
        parent::__construct($auth);

        $this->gradeRepository = $grade;
        $this->lessonRepository = $lesson;
    }


    public function index(Request $request)
    {
        return GradeTransformer::collection($this->gradeRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return GradeTransformer::collection($this->gradeRepository->getAll($request));
    }


    public function store(CreateGradeRequest $request)
    {
        try {
            DB::beginTransaction();
            $grade = $this->gradeRepository->create($request->all());
            event(new GradeCreated($grade));
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
            'message' => trans('backend::grade.message.create success'),
        ]);
    }


    public function find(Grade $grade)
    {
        return new  GradeFullTransformer($grade);
    }

    public function update(Grade $grade, UpdateGradeRequest $request)
    {
       $this->gradeRepository->update($grade, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::grade.message.update success'),
        ]);
    }

    public function destroy(Grade $grade)
    {
        try {
            DB::beginTransaction();
            $this->gradeRepository->destroy($grade);

            $lessons = $this->lessonRepository->newQueryBuilder()
                ->select('id')
                ->where('grade_id', $grade->id)->get();

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
            'message' => trans('backend::grade.message.delete success'),
        ]);
    }

    public function getListStudentsByGrade(Request $request){
        return StudentFullTransformer::collection($this->gradeRepository->getListStudents($request));
    }
    public function regist(Request $request, Grade $grade)
    {
        $student = $request->get('student');
        if ($grade->users()->withTrashed()->where('users.id', $student)->count()> 0) {
            return response()->json([
                'errors' => true,
                'message' => trans('backend::grade.message.regist student exist'),
            ]);
        }
        $grade->users()->attach($student,['course_id' => $grade->course_id]);
        $user = User::query()->withTrashed()->where('id', $student)->first();
        if ($user) {
            event(new StudentRegistedCourse($user, $grade));
        }
        return response()->json([
            'errors' => false,
            'message' => trans('backend::grade.message.regist success'),
        ]);
    }
}
