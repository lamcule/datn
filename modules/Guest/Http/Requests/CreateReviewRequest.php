<?php

namespace Modules\Guest\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    public function rules()
    {
        return [


            'username' => 'required',
            'questions' => 'required',


        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [

            'username.required' => 'Mã học viên bắt buộc',
            'questions.required' => 'Câu hỏi bắt buộc',

        ];
    }
}
