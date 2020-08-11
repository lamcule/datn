<?php

namespace Modules\Admin\Http\Controllers\Api\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function __construct(Authentication $auth, CourseRepository $course)
    {
        parent::__construct($auth);

        $this->courseRepository = $course;
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
        $this->courseRepository->destroy($course);

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
}
