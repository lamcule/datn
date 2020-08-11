<?php

namespace Modules\Admin\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Repositories\TeacherRepository;
use Modules\Admin\Transformers\Teacher\TeacherTransformer;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Http\Controllers\ApiController;

class TeacherController extends ApiController
{
    /**
     * @var TeacherRepository
     */
    private $teacherRepository;

    public function __construct(Authentication $auth, TeacherRepository $teacher)
    {
        parent::__construct($auth);

        $this->teacherRepository = $teacher;
    }


    public function index(Request $request)
    {
        return TeacherTransformer::collection($this->teacherRepository->serverPagingFor($request,'profile'));
    }


    public function all(Request $request)
    {
        return TeacherTransformer::collection($this->teacherRepository->newQueryBuilder()->get());
    }


//    public function store(CreateTeacherRequest $request)
//    {
//        $this->teacherRepository->create($request->all());
//
//        return response()->json([
//            'errors' => false,
//            'message' => trans('backend::teacher.message.create success'),
//        ]);
//    }
//
//
//    public function find(User $user)
//    {
//        return new  TeacherFullTransformer($user);
//    }
//
//    public function update(User $user, UpdateTeacherRequest $request)
//    {
//        $this->teacherRepository->update($user, $request->all());
//
//        return response()->json([
//            'errors' => false,
//            'message' => trans('backend::teacher.message.update success'),
//        ]);
//    }
//
//    public function destroy(User $user)
//    {
//        $this->teacherRepository->destroy($user);
//
//        return response()->json([
//            'errors' => false,
//            'message' => trans('backend::teacher.message.delete success'),
//        ]);
//    }

    public function import(Request $request)
    {



    }
}
