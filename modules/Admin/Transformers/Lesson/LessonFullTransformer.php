<?php

namespace Modules\Admin\Transformers\Lesson;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Grade\GradeFullTransformer;

class LessonFullTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $students = $this->users;
        foreach ($students as $student) {
            $student['checkin_at'] = $student->pivot->checkin_at;
            $student['checkout_at'] = $student->pivot->checkout_at;
        }
        $data = [
            'id' => $this->id,
            'students' => $students,
            'name' => $this->name,
            'topic' => $this->topic,
            'grade_id' => $this->grade_id,
            'course_id' => optional($this->grade)->course->id,
            'target' => $this->target,
            'content' => empty($this->content)? []: $this->content,
            'duration' => $this->duration,
            'document' => $this->document,
            'place' => $this->place,
            'teacher' => $this->teacher,
            'status' => $this->status,
            'province_id'=> $this->province_id,
            'district_id'=> $this->district_id,
            'phoenix_id'=> $this->phoenix_id,
            'grade' => new GradeFullTransformer($this->grade),
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'start_time' => optional($this->start_time)->format('Y-m-d H:i:s'),
            'end_time' => optional($this->end_time)->format('Y-m-d H:i:s'),
            'checkin_url' => route('checkin', ['lesson' => $this->id], true),
            'checkout_url' =>route('checkout', ['lesson' => $this->id], true),
            'review_url' =>route('review', ['lesson' => $this->id], true),
        ];
        return $data;
    }
}
