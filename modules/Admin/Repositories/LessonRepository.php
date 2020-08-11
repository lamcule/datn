<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface LessonRepository extends BaseRepository
{
    public function getListStudents(Request $request);
}
