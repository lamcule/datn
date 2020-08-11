<?php

namespace Modules\Admin\Http\Controllers\Api\Grade;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Events\GradeCreated;
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

    public function __construct(Authentication $auth, GradeRepository $grade)
    {
        parent::__construct($auth);

        $this->gradeRepository = $grade;
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
        $grade = $this->gradeRepository->create($request->all());
        event(new GradeCreated($grade));

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
        $this->gradeRepository->destroy($grade);

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
