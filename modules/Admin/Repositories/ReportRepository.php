<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Repositories\BaseRepository;

interface ReportRepository extends BaseRepository
{
    public function exportGradeDetail(Request $request, Grade $grade);
    public function exportReviewHistory(Request $request);


}
