<?php

namespace Modules\Admin\Transformers\Report;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Course\CourseFullTransformer;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\Question;
use Modules\Mon\Entities\QuestionGroup;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\UserLesson;

class ReportReviewHistoryTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $questions = Question::query()->join('reviews','questions.id','reviews.question_id')->where([
            'reviews.user_id' => $this->user_id,
            'reviews.lesson_id' => $this->lesson_id,
        ])->select('questions.id','questions.content','questions.group_id','reviews.answer')->get();

        $review = Review::where([
            'reviews.user_id' => $this->user_id,
            'reviews.lesson_id' => $this->lesson_id,
        ])->first();
        $data = [
            'created_at' => optional($review)->created_at->format('Y-m-d H:i'),
            'fullname' => optional($this->user)->name,
            'course' => optional(optional($this->lesson)->course)->name,
            'place' => optional(optional($this->lesson)->grade)->place,
            'grade' => optional(optional($this->lesson)->grade)->name,
            'lesson' => optional($this->lesson)->name,
            'questions' => $questions
        ];
        return $data;
    }
}
