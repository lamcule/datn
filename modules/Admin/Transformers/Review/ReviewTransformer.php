<?php

namespace Modules\Admin\Transformers\Review;

use Illuminate\Http\Resources\Json\Resource;


class ReviewTransformer extends Resource
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
            'question_id' => $this->question_id,
            'question_text' => $this->question_text,
            'answer' => $this->question->type == 'rate' ? (int)$this->answer: $this->answer,
            'question_type' => optional($this->question)->type
        ];


        return $data;
    }

}
