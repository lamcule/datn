<?php

namespace Modules\Guest\Transformers;

use Illuminate\Http\Resources\Json\Resource;


class QuestionTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'content' => $this->content,
            'type' => $this->type,
            'answer' => $this->type == 'text'? '': 0,
            'student_note' => ''
        ];

        return $data;
    }

}
