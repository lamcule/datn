<?php

namespace Modules\Admin\Http\Controllers\Api\QuestionGroup;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\QuestionGroup\QuestionGroupTransformer;
use Modules\Mon\Entities\QuestionGroup;
use Modules\Admin\Http\Requests\QuestionGroup\CreateQuestionGroupRequest;
use Modules\Admin\Http\Requests\QuestionGroup\UpdateQuestionGroupRequest;
use Modules\Admin\Repositories\QuestionGroupRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class QuestionGroupController extends ApiController
{
    /**
     * @var QuestionGroupRepository
     */
    private $questiongroupRepository;

    public function __construct(Authentication $auth, QuestionGroupRepository $questiongroup)
    {
        parent::__construct($auth);

        $this->questiongroupRepository = $questiongroup;
    }


    public function index(Request $request)
    {
        return QuestionGroupTransformer::collection($this->questiongroupRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return QuestionGroupTransformer::collection($this->questiongroupRepository->newQueryBuilder()->get());
    }


    public function store(CreateQuestionGroupRequest $request)
    {
        $this->questiongroupRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::questiongroup.message.create success'),
        ]);
    }


    public function find(QuestionGroup $questiongroup)
    {
        return new  QuestionGroupTransformer($questiongroup);
    }

    public function update(QuestionGroup $questiongroup, UpdateQuestionGroupRequest $request)
    {
        $this->questiongroupRepository->update($questiongroup, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::questiongroup.message.update success'),
        ]);
    }

    public function destroy(QuestionGroup $questiongroup)
    {
        $this->questiongroupRepository->destroy($questiongroup);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::questiongroup.message.delete success'),
        ]);
    }
}
