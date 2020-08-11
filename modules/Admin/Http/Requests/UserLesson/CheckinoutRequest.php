<?php

namespace Modules\Admin\Http\Requests\UserLesson;

use Illuminate\Foundation\Http\FormRequest;

class CheckinoutRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lesson_id' => 'required',
            'username' => 'required|exists:users,username'
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'lesson_id.required' => 'Bài học là bắt buộc',
            'username.required' => 'Mã học viên là bắt buộc',
            'username.exists' => 'Mã học viên không tồn tại'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
