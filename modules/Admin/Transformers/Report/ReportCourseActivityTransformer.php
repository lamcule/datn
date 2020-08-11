<?php

namespace Modules\Admin\Transformers\Report;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Course\CourseFullTransformer;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\UserGrade;
use Modules\Mon\Entities\UserLesson;

class ReportCourseActivityTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
	    $total_user_lesson = UserGrade::where('grade_id', $this->id)->count();
	    $reviews = Review::where('grade_id', $this->id)->select('user_id')->get();
	    $review_count = 0;
	    $reviewUsers =[];
	    foreach ($reviews as $item) {
	        if (!in_array($item->user_id, $reviewUsers)){
	            $review_count ++ ;
            }
            $reviewUsers[] = $item->user_id;
        }

	    $data = [
            'id' => $this->id,
            'course' => $this->course? new CourseFullTransformer($this->course): [],
            'grade_name' => $this->name,
            'teacher' => $this->teacher,
            'created_at' => $this->created_at->format('Y-m-d'),

            'area' =>$this->place.', '. optional($this->phoenix)->name.', '. optional($this->district)->name.', '. optional($this->province)->name,
            'hours' => $this->hours,
	        'total_user_register' => $total_user_lesson,
			'total_feedback' => $review_count,
            'number_checkin' =>  $this->number_checkin,
            'number_checkout' => $this->number_checkout,
            'rate_avg' => $this->rate_avg,

        ];
        return $data;
    }
}
