<?php

namespace Modules\Admin\Transformers\UserLesson;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Mon\Entities\Course;

class UserLessonTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,

            'grade_id' => $this->grade_id,
            'grade_name' => optional($this->grade)->name,
            'course_id' => $this->course_id,
            'course_name' => optional($this->course)->name,
            'lesson_id' => $this->lesson_id,
            'lesson_name' => optional($this->lesson)->name,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->username,
            'user_fullname' => optional($this->user)->name,
            'user_link' => route('admin.auth.users.edit', $this->user_id),

            'checkin_at' => optional($this->checkin_at)->format('d-m-Y H:i:s'),
            'checkout_at' => optional($this->checkout_at)->format('d-m-Y H:i:s'),

            'urls' => [
               // 'delete_url' => route('api.userlesson.destroy', $this->id),
            ],
        ];
        return $data;
    }
}
