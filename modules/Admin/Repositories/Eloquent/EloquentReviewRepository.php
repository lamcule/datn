<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\ReviewRepository;
use Modules\Mon\Entities\Question;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\UserReview;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentReviewRepository extends BaseRepository implements ReviewRepository
{
    /**
     * @param Request $request
     * @param null $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function serverPagingForUser(Request $request, $userReview, $relations = null)
    {

        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($userReview) {
            $query->where('lesson_id', $userReview->lesson_id);
            $query->where('user_id', $userReview->user_id);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('question_text', 'LIKE', "%{$keyword}%")
                    ->orWhere('answer', 'LIKE', "%{$keyword}%");
            });
        }
        if ($request->get('course_id') !== null) {
            $course_id = $request->get('course_id');
            $query->where('course_id', $course_id);
        }
        if ($request->get('grade_id') !== null) {
            $grade_id = $request->get('grade_id');
            $query->where('grade_id', $grade_id);
        }
        if ($request->get('lesson_id') !== null) {
            $lesson_id = $request->get('lesson_id');
            $query->where('lesson_id', $lesson_id);
        }
        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->get('group_by') !== null) {
            $query->groupBy(explode(",", $request->get('group_by')));
        }
        return $query->paginate($request->get('per_page', 10));
    }
    public function reviewForGrade(Request $request, $grade, $relations = null) {
       $userLessonReviews = $this->reviewForGradeQuery($grade,$relations);
       $output = [];
       foreach ($userLessonReviews as $row) {
           $textReviews = Review::where([
               'user_id' => $row->user_id,
               'lesson_id' => $row->lesson_id
           ])->join('questions','questions.id', '=', 'reviews.question_id')
               ->where('questions.type','text')->get();
           $questionData = [];
           foreach ($textReviews as $review) {
               $questionData[] = [
                   'question' => $review->question_text,
                   'answer' => $review->answer
               ];
           }
           $output[] = [
               'course' => $grade->course->name,
               'grade' => $grade->name,
               'lesson' => $review->lesson->name,
               'user' => $review->user->name,
               'username' => $review->user->username,
               'reviews' => $questionData

           ];
       }
       return $output;
    }
    public function reviewForGradeQuery($grade, $relations) {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($grade) {

            $query->where('grade_id', $grade->id);
        }

        $query->selectRaw('distinct user_id, lesson_id');
        return $query->get();
    }
    public function getUserReviewHistory(Request $request) {
        $query = $this->newQueryBuilder();
        $query->select('user_id', 'lesson_id')->distinct();

        if (!empty($request->get('username'))) {
            $keyword = $request->get('username');
            $query->whereHas('user', function ($q) use ($keyword) {

                $q->where('username','like', "%$keyword%");
            });
        }
        if (!empty($request->get('name'))) {
            $keyword = $request->get('name');
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name','like', "%$keyword%");
            });
        }
        if (!empty($request->get('email'))) {
            $keyword = $request->get('email');
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('email','like', "%$keyword%");
            });
        }
        if (!empty($request->get('phone'))) {
            $keyword = $request->get('phone');
            $query->whereHas('user.profile', function ($q) use ($keyword) {
                $q->where('phone','like', "%$keyword%");
            });
        }
        if (!empty($request->get('created_at'))) {
            $keyword = $request->get('created_at');
            $query->whereHas('user.profile', function ($q) use ($keyword) {
                $q->whereDate('birth_date', $keyword );
            });
        }
        if (!empty($request->get('course_id'))) {
            $keyword = $request->get('course_id');
            $query->where('course_id', $keyword);
        }
        if (!empty($request->get('grade_id'))) {
            $keyword = $request->get('grade_id');
            $query->where('grade_id', $keyword);
        }
        if (!empty($request->get('lesson_id'))) {
            $keyword = $request->get('lesson_id');
            $query->where('lesson_id', $keyword);
        }
        return $query->paginate($request->get('per_page', 10), ['user_id', 'lesson_id']);

    }
}
