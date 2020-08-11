<?php

namespace Modules\Mon\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class UserTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'createdBy' => $this->createdBy,
            'email_verified_at' => $this->email_verified_at,
            'activated' => $this->activated,
            'last_login' => $this->last_login,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
