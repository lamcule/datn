<?php

namespace Modules\Admin\Http\Controllers\Api\StudentGuest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\Student\StudentFullTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\StudentGuest;
use Modules\Admin\Http\Requests\StudentGuest\CreateStudentGuestRequest;
use Modules\Admin\Http\Requests\StudentGuest\UpdateStudentGuestRequest;
use Modules\Admin\Repositories\StudentGuestRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class StudentGuestController extends ApiController
{
    /**
     * @var StudentGuestRepository
     */
    private $studentguestRepository;

    public function __construct(Authentication $auth, StudentGuestRepository $studentguest)
    {
        parent::__construct($auth);

        $this->studentguestRepository = $studentguest;
    }


    public function index(Request $request)
    {
        return StudentTransformer::collection($this->studentguestRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return StudentTransformer::collection($this->studentguestRepository->newQueryBuilder()->get());
    }


    public function store(CreateStudentGuestRequest $request)
    {
        $this->studentguestRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::studentguest.message.create success'),
        ]);
    }


    public function find(User $studentguest)
    {
        return new  StudentFullTransformer($studentguest);
    }

    public function update(User $studentguest, UpdateStudentGuestRequest $request)
    {
        $this->studentguestRepository->update($studentguest, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::studentguest.message.update success'),
        ]);
    }

    public function destroy(User $studentguest)
    {
        $this->studentguestRepository->destroy($studentguest);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::studentguest.message.delete success'),
        ]);
    }
}
