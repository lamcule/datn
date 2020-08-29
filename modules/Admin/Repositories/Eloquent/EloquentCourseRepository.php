<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\CourseRepository;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\Review;
use Modules\Mon\Entities\UserLesson;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentCourseRepository extends BaseRepository implements CourseRepository
{

    public function getAll(Request $request)
    {
        $courses = Cache::rememberForever('courses', function () {
            return Course::all();
        });
        return $courses;
    }

    public function create($data)
    {

        $model = $this->model->create($data);
        $model = $this->generateAndSaveCode($model);
        Cache::forget('courses');
        return $model;
    }

    public function update($model, $data)
    {
        $model->update($data);
        Cache::forget('courses');
        return $model;
    }

    public function destroy($model)
    {
        $result = $model->delete();
        Cache::forget('courses');
        return $result;
    }

    public function generateAndSaveCode($model)
    {
        $model->code = $model->type . '_' . str_pad($model->id, 3, "0", STR_PAD_LEFT);
        $model->save();
        return $model;
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
        if ($request->get('type') !== null) {
            $type = $request->get('type');
            $query->where('type', 'LIKE', "%{$type}%");
        }
        if ($request->get('role') !== null) {
            $role = $request->get('role');
            $query->where('role', 'LIKE', "%{$role}%");
        }
        if ($request->get('frequency') !== null) {
            $frequency = $request->get('frequency');
            $query->where('frequency', 'LIKE', "%{$frequency}%");
        }
        if ($request->get('scale') !== null) {
            $scale = $request->get('scale');
            $query->where('scale', 'LIKE', "%{$scale}%");
        }
        if ($request->get('object') !== null) {
            $object = $request->get('object');
            $query->where('object', 'LIKE', "%{$object}%");
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

    public function getActiveCourse()
    {
        $query = $this->newQueryBuilder();
        $query->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(10);
        return $query->get();
    }

}
