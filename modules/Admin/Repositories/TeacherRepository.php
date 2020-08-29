<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface TeacherRepository extends BaseRepository
{
    public function serverPagingForReport(Request $request, $relations = null);
    public function getActiveTeacher();
//    public function getStudentLessonReport(Request $request, $relations = null);
}
