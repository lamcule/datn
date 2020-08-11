<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\UserReviewRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentUserReviewRepository extends BaseRepository implements UserReviewRepository
{
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

        if ($request->get('course_id') !== null) {
            $course_id = $request->get('course_id');
            $query->where('course_id', $course_id);
        }
        if ($request->get('grade_id') !== null) {
            $grade_id = $request->get('grade_id');
            $query->where('grade_id', $grade_id);
        }
        if ($request->get('lesson_id') !== null) {
            $lesson_id = $request->get('lesson_id');
            $query->where('lesson_id', $lesson_id);
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
