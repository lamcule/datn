<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Repositories\PhoenixRepository;
use Modules\Mon\Entities\Phoenix;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentPhoenixRepository extends BaseRepository implements PhoenixRepository
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(Request $request) {
        $phoenixes = Cache::rememberForever('phoenixes', function () {
            return Phoenix::all();
        });
        return $phoenixes;
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
