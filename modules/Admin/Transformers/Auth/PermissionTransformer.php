<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\Resource;


class PermissionTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'description' => $this->description,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),

        ];


        return $data;
    }

}
