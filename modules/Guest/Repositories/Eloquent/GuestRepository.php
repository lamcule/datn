<?php

namespace Modules\Guest\Repositories\Eloquent;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Repositories\ReviewRepository;
use Modules\Admin\Repositories\UserReviewRepository;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\QuestionGroup;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\User;
use Modules\Mon\Entities\UserReview;
use Modules\Mon\Repositories\Eloquent\BaseRepository;

class GuestRepository extends BaseRepository implements \Modules\Guest\Repositories\GuestRepository
{
    public function userCheckin(User $user, Lesson $lesson)
    {
        if(!$user->grades()->find($lesson->grade_id)) {
            return false;
        }
        if ($lessonAsm = $user->lessons()->find($lesson->id)) {
            if (!$lessonAsm->pivot->checkin_at) {
                $user->lessons()->updateExistingPivot($lesson->id, [
                    'course_id' => $lesson->grade->course_id,
                    'grade_id' => $lesson->grade_id,
                    'checkin_at' => Carbon::now()
                ]);
                return true;
            }
            else {
                return $lessonAsm->pivot->checkin_at;
            }
        } else {
            $user->lessons()->attach($lesson->id, [
                'course_id' => $lesson->grade->course_id,
                'grade_id' => $lesson->grade_id,
                'checkin_at' => Carbon::now()
            ]);
            return true;
        }
    }

    public function getUser($username)
    {
        $id = $this->parseId($username);
        return $this->newQueryBuilder()->find($id);
    }
    public function getUserByEmail($email)
    {

        return $this->newQueryBuilder()->where('email', $email)->first();
    }

    public function parseId($username)
    {
        $id = str_ireplace('svf', '', $username);
        return (int)$id;
    }

    public function userCheckout(User $user, Lesson $lesson)
    {
        if(!$user->grades()->find($lesson->grade_id)) {
            return false;
        }
        if ($lessonAsm = $user->lessons()->find($lesson->id)) {
            $user->lessons()->updateExistingPivot($lesson->id, [
                'course_id' => $lesson->grade->course_id,
                'grade_id' => $lesson->grade_id,
                'checkout_at' => Carbon::now()
            ]);
            return Carbon::now()->format('Y-m-d H:i:s');

        } else {
            $user->lessons()->attach($lesson->id, [
                'course_id' => $lesson->grade->course_id,
                'grade_id' => $lesson->grade_id,
                'checkout_at' => Carbon::now()
            ]);
            return Carbon::now()->format('Y-m-d H:i:s');
        }
    }
    public function registGrade(User $user, Grade $grade, $registered_at = null) {
        if($user->grades()->find($grade->id)) {
            return false;
        }
        $user->grades()->attach($grade->id,[
            'course_id' => $grade->course_id,
            'registered_at' => $registered_at
        ]);
        return true;
    }
    public function storeReview(User $user, Lesson $lesson, $questions) {
        if(!$user->lessons()->find($lesson->id)) {
            return trans('base::frontend.message.you not checkin this lesson', ['lesson' => $lesson->name ]);
        }

        UserReview::query()->where('user_id', $user->id)->where('lesson_id', $lesson->id)->delete();
        Review::query()->where('user_id', $user->id)->where('lesson_id', $lesson->id)->delete();
        /**
         * @var $userReviewRepository UserReviewRepository
         */
        $userReviewRepository = app(UserReviewRepository::class);
        $userReviewRepository->create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'grade_id' => $lesson->grade_id,
            'course_id' => $lesson->course_id,

        ]);

        /**
         * @var $reviewRepository ReviewRepository
         */
        $reviewRepository = app(ReviewRepository::class);
        foreach ($questions as $question) {
            $reviewRepository->create([
               'user_id' => $user->id,
               'lesson_id' => $lesson->id,
               'grade_id' => $lesson->grade_id,
               'course_id' => $lesson->course_id,
               'question_id' => $question['id'],
               'question_text' => $question['content'],
               'answer' => $question['answer'],
            ]);
        }
        return true;
    }

    public function getQuestionGroup() {
        return Cache::rememberForever('question_groups', function () {
           return QuestionGroup::with(['questions'])->orderBy('order_', 'asc')->get();
        });
    }
}
