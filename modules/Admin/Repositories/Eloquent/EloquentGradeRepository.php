<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\GradeRepository;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\User;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;

class EloquentGradeRepository extends BaseRepository implements GradeRepository
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function getAll(Request $request)
    {
        return Grade::all();
    }

    public function create($data)
    {

        $model = $this->model->create($data);
        $model = $this->generateAndSaveCode($model);
        return $model;
    }

    public function generateAndSaveCode($model)
    {
        $model->code = $model->course_id . '_' . str_pad($model->id, 3, "0", STR_PAD_LEFT);
        $model->save();
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
//        $query->where('type', 'grade');
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%")
                    ->orWhere('place', 'LIKE', "%{$keyword}%");
            });
        }
        if ($request->has('status') && !empty($request->get('status'))) {
            $status = $request->get('status');
            $query->where('status', $status);
        }
        if ($request->get('course') !== null) {
            $course_id = $request->get('course');
            $query->where('course_id', $course_id);
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
        $query->leftJoin('user_grade', 'users.id', '=', 'user_grade.user_id');
        $query->leftJoin('grades', 'user_grade.grade_id', '=', 'grades.id');
        $query->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');
        $query->where('user_grade.grade_id', $request->get('grade'));
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('username', 'LIKE', "%{$keyword}%")
                    ->orWhere('users.name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
            });
        }
        $query->select('users.*');
        return $query->paginate($request->get('per_page', 10));
    }


    public function getStudentActivity(Request $request)
    {
        $query = $this->getStudentActivityQuery($request);
        return $query->paginate($request->get('per_page', 25));

    }

    public function getStudentActivityQuery(Request $request)
    {

        $query = $this->newQueryBuilder();
        $query->select("grades.*",DB::raw("(select count(1) from user_lesson where user_lesson.grade_id = grades.id and checkin_at is not null) as number_checkin"),
            DB::raw("(select count(1) from user_lesson where user_lesson.grade_id = grades.id and checkout_at is not null) as number_checkout"),
            DB::raw("(select ROUND(avg(answer),2) from reviews   INNER JOIN questions on questions.id = reviews.question_id where reviews.grade_id = grades.id and  questions.type ='rate') as rate_avg"));
        if (!empty($request->get('username'))) {
            $keyword = $request->get('username');
             $query->whereHas('users', function ($q) use ($keyword) {

                 $q->where('username','like', "%$keyword%");
             });
        }
        if (!empty($request->get('name'))) {
            $keyword = $request->get('name');
            $query->whereHas('users', function ($q) use ($keyword) {
                $q->where('name','like', "%$keyword%");
            });
        }
        if (!empty($request->get('email'))) {
            $keyword = $request->get('email');
            $query->whereHas('users', function ($q) use ($keyword) {
                $q->where('email','like', "%$keyword%");
            });
        }
        if (!empty($request->get('phone'))) {
            $keyword = $request->get('phone');
            $query->whereHas('users.profile', function ($q) use ($keyword) {
                $q->where('phone','like', "%$keyword%");
            });
        }
        if (!empty($request->get('company'))) {
            $keyword = $request->get('company');
            $query->whereHas('users.profile', function ($q) use ($keyword) {
                $q->where('company','like', "%$keyword%");
            });
        }
        if (!empty($request->get('category'))) {
            $keyword = $request->get('category');
            $query->whereHas('users.profile', function ($q) use ($keyword) {
                $q->where('categories','like', "%$keyword%");
            });
        }
	    if (!empty($request->get('course_id'))) {
		    $course_id = $request->get('course_id');
		    $query->where('grades.course_id', $course_id);
	    }
	    if (!empty($request->get('grade_id'))) {
		    $grade_id = $request->get('grade_id');
		    $query->where('grades.id', $grade_id);
	    }
        if (!empty($request->get('object'))) {
            $object = $request->get('object');
            $query->whereHas('course', function ($q) use ($object) {
                $q->where('object','like', "%$object%");
            });
        }
        return $query;
    }
}
