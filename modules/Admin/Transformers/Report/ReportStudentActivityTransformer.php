<?php

namespace Modules\Admin\Transformers\Report;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Course\CourseFullTransformer;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\UserLesson;

class ReportStudentActivityTransformer extends Resource
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
            'course' => $this->course? new CourseFullTransformer($this->course): [],
            'grade_name' => $this->name,
            'teacher' => $this->teacher,
            'created_at' => $this->created_at->format('Y-m-d'),

            'area' => $this->area,
            'number_checkin' =>  $this->number_checkin,
            'number_checkout' => $this->number_checkout,
            'rate_avg' => $this->rate_avg,
            'total_user_lesson' => UserLesson::where('course_id', $this->id)->count()

        ];
        return $data;
    }
}
