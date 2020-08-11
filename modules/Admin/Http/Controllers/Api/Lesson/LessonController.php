<?php

namespace Modules\Admin\Http\Controllers\Api\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Admin\Transformers\Lesson\LessonFullTransformer;
use Modules\Admin\Transformers\Lesson\LessonTransformer;
use Modules\Admin\Transformers\Lesson\QRCodeTransformer;
use Modules\Admin\Transformers\Student\StudentFullTransformer;
use Modules\Mon\Entities\Lesson;
use Modules\Admin\Http\Requests\Lesson\CreateLessonRequest;
use Modules\Admin\Http\Requests\Lesson\UpdateLessonRequest;
use Modules\Admin\Repositories\LessonRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class LessonController extends ApiController
{
    /**
     * @var GradeRepository
     */
    public $gradeRepository;
    /**
     * @var LessonRepository
     */
    private $lessonRepository;

    public function __construct(Authentication $auth, LessonRepository $lesson, GradeRepository $gradeRepository)
    {
        parent::__construct($auth);

        $this->lessonRepository = $lesson;
        $this->gradeRepository = $gradeRepository;
    }


    public function index(Request $request)
    {
        return LessonTransformer::collection($this->lessonRepository->serverPagingFor($request));
    }

    public function qrcode(Request $request)
    {
        return QRCodeTransformer::collection($this->lessonRepository->serverPagingFor($request));
    }
    public function all(Request $request)
    {
        return LessonTransformer::collection($this->lessonRepository->getAll($request));
    }


    public function store(CreateLessonRequest $request)
    {
        $data = $request->all();
        $grade = $this->gradeRepository->find($data['grade_id']);
        if (!$grade) {
            return response()->json([
                'errors' => true,
                'message' => trans('backend::lesson.message.create fail'),
            ]);
        }
        $data['course_id'] = $grade->course_id;
        $this->lessonRepository->create($data);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::lesson.message.create success'),
        ]);
    }


    public function find(Lesson $lesson)
    {
        return new  LessonFullTransformer($lesson);
    }

    public function update(Lesson $lesson, UpdateLessonRequest $request)
    {
        $this->lessonRepository->update($lesson, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::lesson.message.update success'),
        ]);
    }

    public function destroy(Lesson $lesson)
    {
        $this->lessonRepository->destroy($lesson);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::lesson.message.delete success'),
        ]);
    }

    public function getListStudentsByLesson(Request $request){
        return StudentFullTransformer::collection($this->lessonRepository->getListStudents($request));
    }
}
