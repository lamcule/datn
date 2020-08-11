<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Repositories\DistrictRepository;
use Modules\Mon\Entities\District;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentDistrictRepository extends BaseRepository implements DistrictRepository
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function getAll(Request $request) {
        $districts = Cache::rememberForever('districts', function () {
            return District::all();
        });
        return $districts;
    }

    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query->paginate($request->get('per_page', 10));
    }
}
