<?php

namespace Modules\Admin\Transformers\Phoenix;

use Illuminate\Http\Resources\Json\Resource;


class PhoenixTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'district_id' => $this->district_id,
        ];

        return $data;
    }

}
