<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 9/12/2019
 * Time: 5:44 PM
 */

namespace Modules\Admin\Transformers\Course;


use Illuminate\Http\Resources\Json\Resource;
use Modules\Mon\Services\OlavuiCarbonUtils;

class CourseFullTransformer extends Resource
{

    public function toArray($request)
    {
        $carbonUtil = app(OlavuiCarbonUtils::class);
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'area' => $this->area,
            'role' => $this->role,
            'frequency' => $this->frequency,
            'project' => $this->project,
            'scale' => $this->scale,
            'has_notification' => $this->has_notification,
            'has_email' => $this->has_email,
            'code' => $this->code,
            'object' => $this->object,
            'teacher' => $this->teacher,
            'tuition' => $this->tuition,
            'status' => $this->status,
            'created_by' => $this->created_by ? optional($this->user)->id : null,
            'created_at' => strtotime($this->created_at),
            'updated_at' => strtotime($this->updated_at),
        ];


        return $data;
    }
}
