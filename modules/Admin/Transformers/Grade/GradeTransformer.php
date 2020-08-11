<?php

namespace Modules\Admin\Transformers\Grade;

use Illuminate\Http\Resources\Json\Resource;

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
            'course_id' => $this->course_id,
            'number_of_lesson' => $this->number_of_lesson,
            'place' => $this->place,
            'teacher' => $this->teacher,
            'status' => $this->status,
            'code' => $this->code,
            'hours' => $this->hours,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'teacher_type' => $this->teacher_type,
            'teacher_company' => $this->teacher_company,
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
