<?php

namespace Modules\Admin\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route()->parameter('user');
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                "required",
                "email",
                Rule::unique('users', 'email')->ignore($user->id, 'id')
            ],
            'phone' => [
                "required",
                Rule::unique('profiles', 'phone')->ignore($user->id, 'user_id')
            ]

        ];
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email  is required',
            'password.required' => 'Mật khẩu bắt buộc',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'email.email' => 'Email invalidate',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'Phone number has exist',
            'email.unique' => 'Email has exist',
        ];
    }
}
