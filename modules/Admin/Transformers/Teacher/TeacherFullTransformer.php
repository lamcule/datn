<?php

namespace Modules\Admin\Transformers\Teacher;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Profile\ProfileTransformer;


class TeacherFullTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => optional($this->profile)->phone,
            'description' => $this->description,
            'profile' => new ProfileTransformer($this->profile),
            'checkin_at' => $this->checkin_at,
            'checkout_at' => $this->checkout_at,
            'grade_ids' => $this->grades()->get()->pluck('id')->all(),
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'deleted_at' =>optional($this->deleted_at)->format('d-m-Y'),
            'roles' => $this->getCheckedRoles(),
            'urls' => [
                'delete_url' => route('api.student.destroy', $this->id),
            ],
            'status' => $this->status,
        ];


        return $data;
    }

    private function getCheckedRoles()
    {
        return $this->roles()->get()->pluck('id');
    }
}
