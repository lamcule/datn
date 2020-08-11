<?php

namespace Modules\Admin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;


class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [

            'username' => 'required|unique:users|max:100',
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'username.required' => 'Tên đăng nhập bắt buộc',
            'name.required' => 'Tên đầy đủ bắt buộc',
            'email.required' => 'Email bắt buộc',
            'password.required' => 'Mật khẩu bắt buộc',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'email.email' => 'Email không đúng định dạng',
        ];
    }
}

