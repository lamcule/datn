<?php

namespace Modules\Admin\Transformers\Student;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Profile\ProfileTransformer;


class StudentFullTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => optional($this->profile)->phone,
            'profile' => new ProfileTransformer($this->profile),
            'status' => $this->status,
            'type' => $this->type,
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
        ];


        return $data;
    }

    private function getCheckedRoles()
    {
        return $this->roles()->get()->pluck('id');
    }
}
