<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\Resource;


class UserFullTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'phone' => optional($this->profile)->phone,

            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' =>optional($this->updated_at)->format('d-m-Y'),
            'roles' => $this->getCheckedRoles(),
             'urls' => [
                    'delete_url' => route('api.auth.users.destroy', $this->id),
                ],
        ];


        return $data;
    }
    private function getCheckedRoles(){
        return $this->roles()->get()->pluck('id');
    }
}
