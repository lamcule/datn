<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 9/4/2019
 * Time: 5:12 PM
 */

namespace Modules\Admin\Transformers\Banner;


use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;
use Modules\Mon\Entities\Banner;
use Modules\Mon\Services\OlavuiCarbonUtils;

class BannerTransformer extends Resource
{
    public function toArray($request)
    {
        $user = Auth::user();
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->image,
            'position' => $this->position,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->format('d-m-Y'),
            'updated_at' => optional($this->updated_at)->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.banner.destroy', $this->id),
            ],

        ];

        return $data;
    }
}
