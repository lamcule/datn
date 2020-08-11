<?php

namespace Modules\Admin\Transformers\Report;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Course\CourseFullTransformer;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;

class ReportGradeDetailTransformer extends Resource
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
            'topic' => '',
            'partner' => '',
            'tuition_partner' => '',
            'tuition_svf' => '',
            'course_id' => $this->course_id,
            'course' => new CourseFullTransformer($this->course),
            'number_of_lesson' => $this->hours,
            'hours' => $this->hours,
            'place' => empty($this->place)? '' : $this->place,
            'teacher' => $this->teacher,
            'status' => $this->status,
            'code' => $this->code,
            'province' => $this->province  ,
            'district' => $this->district  ,
            'phoenix' => $this->phoenix ,
            'start_time' => $this->start_time,
            'number_of_participant' => $this->users()->count(),
            'start_day' => $this->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
                $this->start_time)->format('d') : '',
            'start_month' => $this->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
                $this->start_time)->format('m') : '',
            'start_year' => $this->start_time ? Carbon::createFromFormat('Y-m-d H:i:s',
                $this->start_time)->format('Y') : '',
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'register_url' => route('grade.register', ['grade' => $this->id], true),
            'urls' => [
                'delete_url' => route('api.grade.destroy', $this->id),
            ],
        ];
        return $data;
    }
}
