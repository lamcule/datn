<?php

namespace Modules\Admin\Transformers\Grade;

use Illuminate\Http\Resources\Json\Resource;

class GradeFullTransformer extends Resource
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
            'course' => $this->course->name,
            'number_of_lesson' => $this->number_of_lesson,
            'place' => $this->place,
            'teacher' => $this->teacher,
            'status' => $this->status,
            'province_id'=> $this->province_id,
            'district_id'=> $this->district_id,
            'phoenix_id'=> $this->phoenix_id,
            'code' => $this->code,
            'hours' => $this->hours,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'teacher_type' => $this->teacher_type,
            'teacher_company' => $this->teacher_company,
            'created_at' => strtotime($this->created_at),
            'updated_at' => strtotime($this->updated_at)
        ];
        return $data;
    }
}