<?php

namespace Modules\Admin\Transformers\Profile;

use Illuminate\Http\Resources\Json\Resource;


class ProfileTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,

            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'birth_date' => optional($this->birth_date)->format('Y-m-d'),
            'photo' => $this->photo,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'full_name' => $this->full_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'position' => $this->position,
            'company' => $this->company,
            'company_address' => $this->company_address,
            'categories' => $this->categories,
            'personal_categories' => $this->personal_categories,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'phoenix_id' => $this->phoenix_id,
            'province' => $this->province,
            'district' => $this->district,
            'phoenix' => $this->phoenix,
            'description' => $this->description,

        ];


        return $data;
    }

}
