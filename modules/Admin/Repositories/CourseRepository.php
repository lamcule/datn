<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface CourseRepository extends BaseRepository
{
    public function getActiveCourse(Request $request);
}
