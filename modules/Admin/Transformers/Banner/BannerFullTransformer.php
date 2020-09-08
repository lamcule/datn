<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 9/12/2019
 * Time: 5:44 PM
 */

namespace Modules\Admin\Transformers\Banner;


use Illuminate\Http\Resources\Json\Resource;
use Modules\Mon\Services\OlavuiCarbonUtils;

class BannerFullTransformer extends Resource
{

    public function toArray($request)
    {
        $carbonUtil = app(OlavuiCarbonUtils::class);
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'image' => $this->image,
            'position' => $this->position,
            'status' => $this->status,
            'created_at' => strtotime($this->created_at),
            'updated_at' => strtotime($this->updated_at),
        ];


        return $data;
    }
}
