<?php

namespace Modules\Admin\Http\Controllers\Api\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Question;
use Modules\Admin\Http\Requests\Question\CreateQuestionRequest;
use Modules\Admin\Http\Requests\Question\UpdateQuestionRequest;
use Modules\Admin\Repositories\QuestionRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class QuestionController extends ApiController
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    public function __construct(Authentication $auth, QuestionRepository $question)
    {
        parent::__construct($auth);

        $this->questionRepository = $question;
    }


    public function index(Request $request)
    {
        return QuestionTransformer::collection($this->questionRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return QuestionTransformer::collection($this->questionRepository->newQueryBuilder()->get());
    }


    public function store(CreateQuestionRequest $request)
    {
        $this->questionRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::question.message.create success'),
        ]);
    }


    public function find(Question $question)
    {
        return new  QuestionFullTransformer($question);
    }

    public function update(Question $question, UpdateQuestionRequest $request)
    {
        $this->questionRepository->update($question, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::question.message.update success'),
        ]);
    }

    public function destroy(Question $question)
    {
        $this->questionRepository->destroy($question);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::question.message.delete success'),
        ]);
    }
}
