<?php

namespace Modules\Admin\Transformers\Lesson;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Mon\Entities\Course;

class LessonTransformer extends Resource
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
            'topic' => $this->topic,
            'grade_id' => $this->grade_id,
            'course_id' => optional($this->grade)->course_id,
            'target' => $this->target,
            'content' => empty($this->content)? []: $this->content,
            'duration' => $this->duration,
            'document' => $this->document,
            'place' => $this->place,
            'teacher' => $this->teacher,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'start_time' => optional($this->start_time)->format('d-m-Y H:i:s'),
            'end_time' => optional($this->end_time)->format('d-m-Y H:i:s'),
            'urls' => [
                'delete_url' => route('api.lesson.destroy', $this->id),
            ],
        ];
        return $data;
    }
}
