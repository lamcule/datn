<?php

namespace Modules\Admin\Transformers\UserReview;

use Illuminate\Http\Resources\Json\Resource;


class UserReviewTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->username,
            'lesson_id' => $this->lesson_id,
            'lesson_name' => optional($this->lesson)->name,
            'course_id' => $this->course_id,
            'course_name' => $this->course_id != null ? optional($this->course)->name : null,
            'grade_id' => $this->grade_id,
            'grade_name' => $this->grade_id != null ? optional($this->grade)->name : null,

        ];


        return $data;
    }

}
