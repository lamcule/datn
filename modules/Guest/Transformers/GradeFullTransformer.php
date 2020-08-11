<?php

namespace Modules\Guest\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Student\StudentFullTransformer;

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
            'course_name' => $this->course->name,
            'number_of_lesson' => $this->number_of_lesson,
            'place' => $this->place,
            'teacher' => $this->teacher,
            'students' => StudentFullTransformer::collection($this->users),
            'status' => $this->status,
            'province_id'=> $this->province_id,
            'district_id'=> $this->district_id,
            'phoenix_id'=> $this->phoenix_id,
            'created_at' => strtotime($this->created_at),
            'updated_at' => strtotime($this->updated_at)
        ];
        return $data;
    }
}
