<?php

namespace Modules\Admin\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\TeacherRepository;
//use Modules\Guest\Events\TeacherRegistedCourse;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Guest\Repositories\GuestRepository;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Profile;
use Modules\Mon\Events\UserWasCreated;
use Modules\Mon\Events\UserWasDeleting;
use Modules\Mon\Events\UserWasUpdated;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Modules\Mon\Repositories\ProfileRepository;

class EloquentTeacherRepository extends BaseRepository implements TeacherRepository
{
    public function getUsernameFromId($id)
    {
        return 'GV' . str_pad($id, 6, "0", STR_PAD_LEFT);
    }

    public function create($data)
    {
        $data['username'] = $data['email'];
        $data['password'] = \Hash::make(env('TEACHER_PASSWORD'));
        $data['name'] =$data['last_name'] . ' ' . $data['first_name'] ;
        $data['full_name'] = $data['last_name'] . ' ' . $data['first_name'] ;
        // create user
        $user = $this->model->create($data);

        // reasign username
        $data['username'] = $this->getUsernameFromId($user->id);
        $user->update($data);

        // create profile
        $user->profile()->create($data);
        event(new UserWasCreated($user, $data));
        if (isset($data['grade_ids'])) {
            $this->registGrade($user, $data['grade_ids']);
        }

        return $user;
    }

    public function update($model, $data)
    {
        $data['name'] =$data['last_name'] . ' ' . $data['first_name'] ;
        $data['full_name'] = $data['last_name'] . ' ' . $data['first_name'] ;
        $model->update($data);

        if (isset($data['grade_ids'])) {
            $this->registGrade($model, $data['grade_ids']);
        }
        /**
         * @var $profileRepo ProfileRepository
         */
        $profileRepo = app(ProfileRepository::class);
        $profile = $profileRepo->findByAttributes(['user_id' => $model->id]);

        //create profile if not exist
        if ($profile) {
            $profileRepo->update($profile, $data);
        } else {
            $model->profile()->create($data);
        }
        event(new UserWasUpdated($model, $data));
        return $model;
    }

    public function destroy($model)
    {
        $model->email = time() . '_' . $model->email;
        event(new UserWasDeleting($model));
        return $model->delete();
    }


    /**
     *
     * @param Request $request
     * @param null $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder()->withTrashed();
        $query->where('type', 'teacher');
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('username', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%");

            })->orWhereHas('profile', function ($query) use ($keyword) {
                $query->where('phone', 'LIKE', "%{$keyword}%");
            });

        }
        if ($request->has('status') && !empty($request->get('status'))) {
            $status = $request->get('status');
            $query->where('status', $status);
        }
        if ($request->get('name') !== null) {
            $name = $request->get('name');
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($request->get('email') !== null) {
            $email = $request->get('email');
            $query->where('email', 'LIKE', "%{$email}");
        }
        if ($request->get('province_id') !== null) {
            $province_id = $request->get('province_id');
            $query->whereHas('profile', function ($query) use ($province_id) {
                $query->where('province_id', $province_id);
            });
        }
        if ($request->get('categories') !== null) {
            $categories = $request->get('categories');
            $categories = explode('/', $categories);
            $query->whereHas('profile', function ($query) use ($categories) {
                foreach ($categories as $keyword) {
                    $query->where('categories', 'LIKE', "%{$keyword}%");
                }
            });
        }
        if ($request->get('personal_categories') !== null) {
            $personal_categories = $request->get('personal_categories');
            $query->whereHas('profile', function ($query) use ($personal_categories) {
                $query->where('personal_categories', 'LIKE', "%{$personal_categories}%");
            });
        }
        if ($request->get('gender') !== null) {
            $gender = $request->get('gender');
            $query->whereHas('profile', function ($query) use ($gender) {
                $query->where('gender', 'LIKE', "%{$gender}%");
            });
        }
        if ($request->get('company') !== null) {
            $company = $request->get('company');
            $query->whereHas('profile', function ($query) use ($company) {
                $query->where('company', 'LIKE', "%{$company}%");
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
        return $query->paginate($request->get('per_page', 10));
    }

    /**
     *
     * @param Request $request
     * @param null $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function serverPagingForReport(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder()->withTrashed();
        $query->where('type', 'teacher');
        if ($relations) {
            $query = $query->with($relations);
        }
        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('username', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%");
            });
        }
        if ($request->has('course_id') && !empty($request->get('course_id'))) {
            $course_id = $request->get('course_id');
            $query->whereHas('courses', function ($query) use ($course_id) {
                $query->where('course_id', $course_id);
            });
        }
        if ($request->has('grade_id') && !empty($request->get('grade_id'))) {
            $grade_id = $request->get('grade_id');
            $query->whereHas('grades', function ($query) use ($grade_id) {
                $query->where('grade_id', $grade_id);
            });
        }
        if ($request->has('lesson_id') && !empty($request->get('lesson_id'))) {
            $lesson_id = $request->get('lesson_id');
            $query->whereHas('lessons', function ($query) use ($lesson_id) {
                $query->where('lesson_id', $lesson_id);
            });
        }
        if ($request->has('status') && !empty($request->get('status'))) {
            $status = $request->get('status');
            $query->where('status', $status);
        }
        if ($request->get('name') !== null) {
            $name = $request->get('name');
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($request->get('email') !== null) {
            $email = $request->get('email');
            $query->where('email', 'LIKE', "%{$email}");
        }
        if ($request->get('province_id') !== null) {
            $province_id = $request->get('province_id');
            $query->whereHas('profile', function ($query) use ($province_id) {
                $query->where('province_id', $province_id);
            });
        }
        if ($request->get('categories') !== null) {
            $categories = $request->get('categories');
            $query->whereHas('profile', function ($query) use ($categories) {
                $query->where('categories', 'LIKE', "%{$categories}%");
            });
        }
        if ($request->get('personal_categories') !== null) {
            $personal_categories = $request->get('personal_categories');
            $query->whereHas('profile', function ($query) use ($personal_categories) {
                $query->where('personal_categories', 'LIKE', "%{$personal_categories}%");
            });
        }
        if ($request->get('gender') !== null) {
            $gender = $request->get('gender');
            $query->whereHas('profile', function ($query) use ($gender) {
                $query->where('gender', 'LIKE', "%{$gender}%");
            });
        }
        if ($request->get('company') !== null) {
            $company = $request->get('company');
            $query->whereHas('profile', function ($query) use ($company) {
                $query->where('company', 'LIKE', "%{$company}%");
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
        return $query->paginate($request->get('per_page', 10));
    }

    public function registGrade($user, $gradesId)
    {

        $message = '';
        $status = true;
        $gradeJoined = $user->grades()->get()->pluck('id')->all();
        $user->grades()->detach();
        $guestRepository = app(GuestRepository::class);
        if (count($gradesId) > 0) {
            foreach ($gradesId as $gradeId) {
                /** @var Grade $grade */
                $grade = Grade::query()->where('id', $gradeId)->first();
                if (!$grade) {
                    $message .= "Lớp học $gradeId không tồn tại. ";
                    $status = false;
                } else {
                    // regist grade
                    $result = $guestRepository->registGrade($user, $grade);
                    if ($result === true) {
                        if (!in_array($grade->id, $gradeJoined)) {
                            event(new StudentRegistedCourse($user, $grade));
                        }

                        $message = "";
                        $status = true;

                    } else {
                        $message .= "Học viên đã đăng ký khoá học $gradeId ";
                        $status = false;
                    }
                }
            }
        }
    }


    public function getTeacherLessonReport(Request $request, $relations = null)
    {
        $query = $this->getTeacherLessonReportQuery($request);
        return $query->paginate($request->get('per_page', 25));
    }

    public function getTeacherLessonReportQuery(Request $request)
    {
        $lesson_id = $request->get('lesson_id');
        $query = $this->newQueryBuilder();
        $query->select("users.*", DB::raw("(select checkin_at from user_lesson where user_lesson.lesson_id = $lesson_id and user_lesson.user_id = users.id limit 1) as checkin_at"),
            DB::raw("(select checkout_at from user_lesson where user_lesson.lesson_id = $lesson_id and user_lesson.user_id = users.id limit 1) as checkout_at"),
            DB::raw("(select answer from reviews  where question_id=12 and reviews.lesson_id = $lesson_id and reviews.user_id = users.id limit 1 ) as feedback"));
        $query->whereHas('lessons', function ($q) use ($lesson_id) {
            $q->where('user_lesson.lesson_id', $lesson_id);
        });
        return $query;
    }

    public function getActiveTeacher() {
        $query = $this->newQueryBuilder();
        $query->where('type', 'teacher')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(10);
        return $query->get();
    }
}
