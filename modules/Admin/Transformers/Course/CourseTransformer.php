<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 9/4/2019
 * Time: 5:12 PM
 */

namespace Modules\Admin\Transformers\Course;


use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;
use Modules\Mon\Entities\Course;
use Modules\Mon\Services\OlavuiCarbonUtils;

class CourseTransformer extends Resource
{
    public function toArray($request)
    {
        $user = Auth::user();
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
            'has_notification' => $this->has_notification,
            'has_email' => $this->has_email,
            'code' => $this->code,

            'scale' => $this->scale,
            'object' => $this->object,
            'teacher' => $this->teacher,
            'tuition' => $this->tuition,
            'status' => $this->status,
            'created_by' => $this->created_by ? optional($this->user)->username : null,
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.course.destroy', $this->id),
            ],
//            'actions' => $this->hasAction($user),
//            'preview_url' => $this->getUrlByLocale(current_locale())
            'view_url' => route('admin.course.view', $this->id),

        ];

//        foreach (supported_locales() as $locale => $supportedLocale) {
//            $data[$locale] = [];
//            foreach ($this->translatedAttributes as $translatedAttribute) {
//                $data[$locale][$translatedAttribute] = $this->translateOrNew($locale)->$translatedAttribute;
//            }
//        }

        return $data;
    }
}
