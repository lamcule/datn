<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/10/19
 * Time: 1:10 PM
 */

namespace Modules\Admin\Entities;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Admin\Transformers\Profile\ProfileTransformer;
use Modules\Admin\Transformers\Student\StudentTransformer;
use Modules\Mon\Entities\User;

class StudentExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $request = $this->request;
        $query = User::query()->withTrashed()
            ->where('type', 'student')
            ->with('profile');
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
        return $query;
    }
    public function headings(): array
    {
        return [
            'User ID',
            'Full name',
            'Date of birth',
            'Sex',
            'Address',
            'Email',
            'Mobile phone',
            'Registration date',
            'Company',
            'Work area',
            'Organization group',
            'Individual group'
        ];
    }
    /**
     * @var User $user
     */
    public function map($user): array
    {
        return [
            $user->username,
            optional($user->profile)->full_name,
            optional(optional($user->profile)->birth_date)->format('Y-m-d'),
            optional($user->profile)->gender,
            optional($user->profile)->address .', '. optional($user->profile->phoenix)->name.', '.($user->profile->district? 'Quận ' : ''). optional($user->profile->district)->name.', '. optional($user->profile->province)->name,
            $user->email,
            optional($user->profile)->phone,
            optional($user->created_at)->format('Y-m-d'),
            optional($user->profile)->company,
            optional($user->profile)->company_address,

            optional($user->profile)->categories? implode(', ',optional($user->profile)->categories): '',
            optional($user->profile)->personal_categories? implode(', ',optional($user->profile)->personal_categories): '',

        ];
    }
}
