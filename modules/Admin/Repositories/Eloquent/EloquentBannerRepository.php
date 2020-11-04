<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Repositories\BannerRepository;
use Modules\Mon\Entities\Banner;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentBannerRepository extends BaseRepository implements BannerRepository
{
    public function getAll(Request $request)
    {
        return Banner::all();
    }

    public function create($data)
    {

        $model = $this->model->create($data);
        return $model;
    }

    public function update($model, $data)
    {
        $model->update($data);
        return $model;
    }

    public function destroy($model)
    {
        $result = $model->delete();
        return $result;
    }

    /**
     * @param Request $request
     * @param null $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%");
            });
        }
        if ($request->has('status') && !empty($request->get('status'))) {
            $status = $request->get('status');
            $query->where('status', $status);
        }
        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $query->orderBy($request->get('order_by'), $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->get('group_by') !== null) {
            $query->groupBy(explode(",", $request->get('group_by')));
        }
        return $query->paginate($request->get('per_page', 10));
    }
}
