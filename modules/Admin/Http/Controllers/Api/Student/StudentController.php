<?php

namespace Modules\Admin\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Transformers\Student\StudentFullTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Admin\Transformers\Student\UserFullTransformer;
use Modules\Admin\Transformers\Student\UserTransformer;
use Modules\Mon\Entities\Student;
use Modules\Admin\Http\Requests\Student\CreateStudentRequest;
use Modules\Admin\Http\Requests\Student\UpdateStudentRequest;
use Modules\Admin\Repositories\StudentRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class StudentController extends ApiController
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(Authentication $auth, StudentRepository $student)
    {
        parent::__construct($auth);

        $this->studentRepository = $student;
    }


    public function index(Request $request)
    {
        return StudentTransformer::collection($this->studentRepository->serverPagingFor($request,'profile'));
    }


    public function all(Request $request)
    {
        return StudentTransformer::collection($this->studentRepository->newQueryBuilder()->get());
    }


    public function store(CreateStudentRequest $request)
    {
        $this->studentRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::student.message.create success'),
        ]);
    }


    public function find(User $user)
    {
        return new  StudentFullTransformer($user);
    }

    public function update(User $user, UpdateStudentRequest $request)
    {
        $this->studentRepository->update($user, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::student.message.update success'),
        ]);
    }

    public function destroy(User $user)
    {
        $this->studentRepository->destroy($user);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::student.message.delete success'),
        ]);
    }

    public function import(Request $request)
    {

    }

    public function saveContact(Request $request)
    {
        $rules = [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required',
        ];
        $messages = [
            'first_name.required' => 'Vui lòng nhập họ.',
            'first_name.max' => 'Vui lòng nhập họ hợp lệ',
            'last_name.required' => 'Vui lòng nhập tên.',
            'last_name.max' => 'Vui lòng nhập tên hợp lệ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Vui lòng nhập email hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
        ];
        $validatedData = Validator::make($request->all(), $rules, $messages);
        if ($validatedData->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validatedData->errors(),
            ]);
        }
        $this->studentRepository->create($request->all());
        return response()->json([
            'error' => false,
            'message' => trans('backend::student.message.create success'),
        ]);
    }
}
