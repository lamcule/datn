<?php

namespace Modules\Admin\Transformers\District;

use Illuminate\Http\Resources\Json\Resource;


class DistrictTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'province_id' => $this->province_id,
        ];

        return $data;
    }

}
