<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Admin\Repositories\UserLessonRepository;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentUserLessonRepository extends BaseRepository implements UserLessonRepository
{
    /**
     * @param Request $request
     * @param null $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->getCheckinoutQuery($request, $relations);
        return $query->paginate($request->get('per_page', 10));
    }
    public function getCheckinoutQuery(Request $request, $relations = null) {
        $query = $this->newQueryBuilder();
//        $query->where('type', 'grade');
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('grade') !== null) {
            $grade_id = $request->get('grade');
            $query->where('grade_id', 'LIKE', "%{$grade_id}%");
        }
        if ($request->get('grade_id') !== null) {
            $grade_id = $request->get('grade_id');
            $query->where('grade_id',$grade_id);
        }
        if ($request->get('course_id') !== null) {
            $course_id = $request->get('course_id');
            $query->where('course_id',$course_id);
        }
        if ($request->get('lesson_id') !== null) {
            $lesson_id = $request->get('lesson_id');
            $query->where('lesson_id',$lesson_id);
        }
        if ($request->get('full_name') !== null) {
            $full_name = $request->get('full_name');
            $query->whereHas('user', function ($query) use ($full_name) {
                $query->where('users.name', 'LIKE', "%{$full_name}%");
            });
        }
        if ($request->get('username') !== null) {
            $username = $request->get('username');
            $query->whereHas('user', function ($query) use ($username) {
                $query->where('users.username', 'LIKE', "%{$username}%");
            });
        }
        if ($request->get('email') !== null) {
            $email = $request->get('email');
            $query->whereHas('user', function ($query) use ($email) {
                $query->where('users.email', 'LIKE', "%{$email}%");
            });
        }
        if ($request->get('phone') !== null) {
            $phone = $request->get('phone');
            $query->whereHas('user.profile', function ($query) use ($phone) {
                $query->where('profiles.phone', 'LIKE', "%{$phone}%");
            });
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
        return $query;
    }
}
