<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface StudentRepository extends BaseRepository
{
    public function serverPagingForReport(Request $request, $relations = null);
    public function getStudentLessonReport(Request $request, $relations = null);
}
