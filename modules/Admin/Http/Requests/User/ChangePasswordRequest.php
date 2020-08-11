<?php

namespace Modules\Admin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|confirmed|min:6',
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

            'password.required' => 'Mật khẩu bắt buộc',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',

        ];
    }
}
