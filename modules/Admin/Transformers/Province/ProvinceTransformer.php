<?php

namespace Modules\Admin\Transformers\Province;

use Illuminate\Http\Resources\Json\Resource;


class ProvinceTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
        ];


        return $data;
    }

}