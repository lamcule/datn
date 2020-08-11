<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Events\Lesson\LessonWasCreated;
use Modules\Admin\Events\Lesson\LessonWasUpdated;
use Modules\Admin\Repositories\LessonRepository;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\User;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentLessonRepository extends BaseRepository implements LessonRepository
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll(Request $request) {
        $lessons = Cache::rememberForever('lessons', function () {
            return Lesson::all();
        });
        return $lessons;
    }

    public function create($data)
    {

        $model = $this->model->create($data);
        Cache::forget('lessons');
        event(new LessonWasCreated($model, $data));
        return $model;
    }

    public function update($model, $data)
    {
        $model->update($data);
        Cache::forget('lessons');
        event(new LessonWasUpdated($model, $data));
        return $model;
    }

    public function destroy($model)
    {
        $result = $model->delete();
        Cache::forget('lessons');
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
//        $query->where('type', 'grade');
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
        if ($request->get('grade') !== null) {
            $grade_id = $request->get('grade');
            $query->where('grade_id', 'LIKE', "%{$grade_id}%");
        }
        if ($request->get('grade_id') !== null) {
            $grade_id = $request->get('grade_id');
            $query->where('grade_id', $grade_id);
        }
        if ($request->get('course_id') !== null) {
            $course_id = $request->get('course_id');
            $query->where('course_id', $course_id);
        }
        if ($request->get('lesson_id') !== null) {
            $lesson_id = $request->get('lesson_id');
            $query->where('id', $lesson_id);
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

    public function getListStudents(Request $request)
    {
        $query = User::query()->withTrashed();
        $query->leftJoin('user_lesson', 'users.id', '=', 'user_lesson.user_id');
        $query->leftJoin('lessons', 'user_lesson.lesson_id', '=', 'lessons.id');
        $query->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');
        $query->where('user_lesson.lesson_id', $request->get('lesson'));
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('username', 'LIKE', "%{$keyword}%")
                    ->orWhere('users.name', 'LIKE', "%{$keyword}%");
            });
        }
        $query->select('users.*', 'user_lesson.checkin_at', 'user_lesson.checkout_at');
        return $query->paginate($request->get('per_page', 10));
    }
}
