<?php

namespace Modules\Admin\Transformers\QuestionGroup;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Mon\Entities\Question;

class QuestionGroupTransformer extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'order_' => $this->order_,
            'questions' => Question::where('group_id', $this->id)->get()

        ];
        return $data;
    }
}
