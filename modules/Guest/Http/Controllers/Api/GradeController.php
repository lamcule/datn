<?php

namespace Modules\Guest\Http\Controllers\Api;


use Modules\Guest\Transformers\GradeFullTransformer;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Http\Controllers\ApiController;


class GradeController extends ApiController
{


    public function find($grade)
    {
        $gradeModel = Grade::find($grade);
        return new GradeFullTransformer($gradeModel);
    }


}
