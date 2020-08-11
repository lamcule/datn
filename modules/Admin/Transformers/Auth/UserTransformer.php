<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\Resource;


class UserTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => optional($this->profile)->phone,
            'username' => $this->username,

            'status' => $this->status,
            'created_by' => $this->created_by,
            'createdBy' => $this->createdBy,
            'email_verified_at' => $this->email_verified_at,
            'activated' => $this->activated,
            'last_login' => $this->last_login,
            'created_at' => optional($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' =>optional($this->updated_at)->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.auth.users.destroy', $this->id),
            ],
        ];


        return $data;
    }

}