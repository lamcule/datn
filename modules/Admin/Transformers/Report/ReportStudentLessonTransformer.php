<?php

namespace Modules\Admin\Transformers\Report;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Course\CourseFullTransformer;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\UserLesson;

class ReportStudentLessonTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $address= '';
        $lesson = Lesson::query()->where('id', $request->get('lesson_id'))->first();
        if ($lesson) {
            $grade = $lesson->grade;
            $address =$grade->place.', '. optional($grade->phoenix)->name.', '. optional($grade->district)->name.', '. optional($grade->province)->name;
        }
        $data = [
            'id' => $this->id,
	        'username'=>$this->username,
	        'name'=>$this->name,
	        'dob'=>optional(optional($this->profile)->birth_date)->format('Y-m-d'),
	        'gender'=>optional($this->profile)->gender,
	        'address'=> $address,
	        'email'=>$this->email,
	        'phone'=>optional($this->profile)->phone,
	        'reg_at'=>$this->created_at,
	        'company'=>optional($this->profile)->company,
	        'company_address'=>optional($this->profile)->company_address,
	        'categories'=>optional($this->profile)->categories,
	        'personal_categories'=>optional($this->profile)->personal_categories,
	        'checkin_at'=>$this->checkin_at,
	        'checkout_at'=>$this->checkout_at,
	        'feedback'=>$this->feedback,
        ];
        return $data;
    }
}
