<?php

namespace Modules\Guest\Transformers;

use Illuminate\Http\Resources\Json\Resource;


class QuestionGroupTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'questions' => QuestionTransformer::collection($this->questions)

        ];

        return $data;
    }

}
