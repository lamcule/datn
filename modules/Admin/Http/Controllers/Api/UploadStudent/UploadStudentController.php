<?php

namespace Modules\Admin\Http\Controllers\Api\UploadStudent;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\UploadStudent;
use Modules\Admin\Http\Requests\UploadStudent\CreateUploadStudentRequest;
use Modules\Admin\Http\Requests\UploadStudent\UpdateUploadStudentRequest;
use Modules\Admin\Repositories\UploadStudentRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class UploadStudentController extends ApiController
{
    /**
     * @var UploadStudentRepository
     */
    private $uploadstudentRepository;

    public function __construct(Authentication $auth, UploadStudentRepository $uploadstudent)
    {
        parent::__construct($auth);

        $this->uploadstudentRepository = $uploadstudent;
    }


    public function index(Request $request)
    {
        return UploadStudentTransformer::collection($this->uploadstudentRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return UploadStudentTransformer::collection($this->uploadstudentRepository->newQueryBuilder()->get());
    }


    public function store(CreateUploadStudentRequest $request)
    {
        $this->uploadstudentRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::uploadstudent.message.create success'),
        ]);
    }


    public function find(UploadStudent $uploadstudent)
    {
        return new  UploadStudentFullTransformer($uploadstudent);
    }

    public function update(UploadStudent $uploadstudent, UpdateUploadStudentRequest $request)
    {
        $this->uploadstudentRepository->update($uploadstudent, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::uploadstudent.message.update success'),
        ]);
    }

    public function destroy(UploadStudent $uploadstudent)
    {
        $this->uploadstudentRepository->destroy($uploadstudent);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::uploadstudent.message.delete success'),
        ]);
    }
}
