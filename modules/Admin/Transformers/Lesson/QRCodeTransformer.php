<?php

namespace Modules\Admin\Transformers\Lesson;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Mon\Entities\Course;

class QRCodeTransformer extends Resource
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
            'name' => $this->name,

            'grade_id' => $this->grade_id,
            'grade_name' => optional($this->grade)->name,
            'course_id' => $this->course_id,
            'course_name' => optional($this->course)->name,

            'status' => $this->status,

            'start_time' => optional($this->start_time)->format('d-m-Y H:i:s'),
            'end_time' => optional($this->end_time)->format('d-m-Y H:i:s'),
            'checkin_url' => route('admin.checkinqr', ['lesson' => $this->id], true),
            'checkout_url' =>route('admin.checkoutqr', ['lesson' => $this->id], true),
            'review_url' =>route('admin.reviewqr', ['lesson' => $this->id], true),
            'urls' => [
                'delete_url' => route('api.lesson.destroy', $this->id),
            ],
        ];
        return $data;
    }
}
