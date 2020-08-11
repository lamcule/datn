<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\Resource;


class UserPermissionsTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,


        ];


        return $data;
    }

}