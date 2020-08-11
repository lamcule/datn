<?php

namespace Modules\Admin\Http\Controllers\Api\UserReview;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\UserReview\UserReviewTransformer;
use Modules\Mon\Entities\UserReview;
use Modules\Admin\Http\Requests\UserReview\CreateUserReviewRequest;
use Modules\Admin\Http\Requests\UserReview\UpdateUserReviewRequest;
use Modules\Admin\Repositories\UserReviewRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class UserReviewController extends ApiController
{
    /**
     * @var UserReviewRepository
     */
    private $userreviewRepository;

    public function __construct(Authentication $auth, UserReviewRepository $userreview)
    {
        parent::__construct($auth);

        $this->userreviewRepository = $userreview;
    }


    public function index(Request $request)
    {
        return UserReviewTransformer::collection($this->userreviewRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return UserReviewTransformer::collection($this->userreviewRepository->newQueryBuilder()->get());
    }


    public function store(CreateUserReviewRequest $request)
    {
        $this->userreviewRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::userreview.message.create success'),
        ]);
    }


    public function find(UserReview $userreview)
    {
        return new  UserReviewTransformer($userreview);
    }

    public function update(UserReview $userreview, UpdateUserReviewRequest $request)
    {
        $this->userreviewRepository->update($userreview, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::userreview.message.update success'),
        ]);
    }

    public function destroy(UserReview $userreview)
    {
        $this->userreviewRepository->destroy($userreview);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::userreview.message.delete success'),
        ]);
    }
}
