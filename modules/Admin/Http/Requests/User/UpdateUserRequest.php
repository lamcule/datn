<?php

namespace Modules\Admin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'=>"required",
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'confirmed',
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
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'username.required' => 'Tên đăng nhập bắt buộc',
            'name.required' => 'Tên đầy đủ bắt buộc',
            'email.required' => 'Email bắt buộc',
            'password.required' => 'Mật khẩu bắt buộc',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'email.email' => 'Email không đúng định dạng',
        ];
    }
}
