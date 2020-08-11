<?php

namespace Modules\Admin\Http\Controllers\Api\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\Review\ReviewTransformer;
use Modules\Mon\Entities\Review;
use Modules\Admin\Http\Requests\Review\CreateReviewRequest;
use Modules\Admin\Http\Requests\Review\UpdateReviewRequest;
use Modules\Admin\Repositories\ReviewRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\UserReview;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ReviewController extends ApiController
{
    /**
     * @var ReviewRepository
     */
    private $reviewRepository;

    public function __construct(Authentication $auth, ReviewRepository $review)
    {
        parent::__construct($auth);

        $this->reviewRepository = $review;
    }


    public function index(Request $request, UserReview $userreview)
    {
        return ReviewTransformer::collection($this->reviewRepository->serverPagingForUser($request, $userreview));
    }


    public function all(Request $request)
    {
        return ReviewTransformer::collection($this->reviewRepository->newQueryBuilder()->get());
    }


    public function store(CreateReviewRequest $request)
    {
        $this->reviewRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::review.message.create success'),
        ]);
    }


    public function find(Review $review)
    {
        return new  ReviewFullTransformer($review);
    }

    public function update(Review $review, UpdateReviewRequest $request)
    {
        $this->reviewRepository->update($review, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::review.message.update success'),
        ]);
    }

    public function destroy(Review $review)
    {
        $this->reviewRepository->destroy($review);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::review.message.delete success'),
        ]);
    }
}
