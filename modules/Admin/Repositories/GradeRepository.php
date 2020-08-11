<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface GradeRepository extends BaseRepository
{
    public function getListStudents(Request $request);
    public function getStudentActivity(Request $request);

    public function getStudentActivityQuery(Request $request);
}
