<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\Resource;


class RoleTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'description' => $this->description,
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' =>optional($this->updated_at)->format('d-m-Y'),
            'checkedPermissions' => $this->getCheckedPermissions()

        ];


        return $data;
    }
    public function getCheckedPermissions() {
        return $this->getAllPermissions()->pluck('id');
    }

}
