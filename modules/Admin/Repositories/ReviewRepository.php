<?php

namespace Modules\Admin\Repositories;

use Illuminate\Http\Request;
use Modules\Mon\Repositories\BaseRepository;

interface ReviewRepository extends BaseRepository
{
    public function serverPagingForUser(Request $request, $userReview, $relations = null);
    public function reviewForGrade(Request $request, $grade, $relations = null);
    public function getUserReviewHistory(Request $request);
}
