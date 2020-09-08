<?php

namespace Modules\Admin\Transformers\Grade;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Teacher\TeacherTransformer;

class GradeTransformer extends Resource
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
            'course_id' => $this->course,
            'course' => $this->course ? $this->course->name: '',
            'number_of_lesson' => $this->number_of_lesson,
            'place' => $this->place,
            'teacher' => $this->teacher,
            'status' => $this->status,
            'code' => $this->code,
            'hours' => $this->hours,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'register_url' =>route('grade.register', ['grade' => $this->id], true),
            'urls' => [
                'delete_url' => route('api.grade.destroy', $this->id),
            ],
        ];
        return $data;
    }
}
