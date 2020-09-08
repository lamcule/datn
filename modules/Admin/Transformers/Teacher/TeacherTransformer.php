<?php
namespace Modules\Admin\Transformers\Teacher;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Grade\GradeTransformer;
use Modules\Admin\Transformers\Profile\ProfileTransformer;


class TeacherTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => optional($this->profile)->phone,
            'username' => $this->username,
            'profile' =>$this->profile?  new ProfileTransformer($this->profile) : [],
            'grades' => GradeTransformer::collection($this->grades),
            'created_by' => $this->created_by,
            'createdBy' => $this->createdBy,
            'email_verified_at' => $this->email_verified_at,
            'activated' => $this->activated,
            'last_login' => $this->last_login,
            'created_at' => optional($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' =>optional($this->updated_at)->format('d-m-Y'),
            'deleted_at' =>optional($this->deleted_at)->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.auth.users.destroy', $this->id),
            ],
            'status' => $this->status,
        ];


        return $data;
    }

}
