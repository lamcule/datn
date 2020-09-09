<?php

namespace Modules\Admin\Repositories\Eloquent;

use Modules\Admin\Repositories\StudentGuestRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Guest\Repositories\GuestRepository;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Profile;
use Modules\Mon\Events\UserWasCreated;
use Modules\Mon\Events\UserWasDeleting;
use Modules\Mon\Events\UserWasUpdated;
use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Modules\Mon\Repositories\ProfileRepository;

class EloquentStudentGuestRepository extends BaseRepository implements StudentGuestRepository
{
    public function getUsernameFromId($id)
    {
        return 'SVF' . str_pad($id, 6, "0", STR_PAD_LEFT);
    }

    public function create($data)
    {
        $data['username'] = $data['email'];
        $data['password'] = '123456svf';
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
        $query->where('type', 'student');
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
}
