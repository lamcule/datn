<?php

namespace Modules\Admin\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeacherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email',
            'phone' => 'required|unique:profiles,phone',
        ];
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
