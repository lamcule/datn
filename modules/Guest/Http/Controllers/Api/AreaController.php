<?php

namespace Modules\Guest\Http\Controllers\Api;


use Illuminate\Support\Facades\Cache;
use Modules\Guest\Transformers\DistrictTransformer;
use Modules\Guest\Transformers\PhoenixTransformer;
use Modules\Guest\Transformers\ProvinceTransformer;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;
use Modules\Mon\Http\Controllers\ApiController;


class AreaController extends ApiController
{


    public function provinces()
    {
        $provinces = Cache::rememberForever('provinces', function () {
            return Province::all();
        });
        return ProvinceTransformer::collection($provinces);
    }
    public function districts()
    {
        $districts = Cache::rememberForever('districts', function () {
            return District::all();
        });
        return DistrictTransformer::collection($districts);
    }
    public function phoenixes()
    {
        $phoenixes = Cache::rememberForever('phoenixes', function () {
            return Phoenix::all();
        });
        return PhoenixTransformer::collection($phoenixes);
    }
}
