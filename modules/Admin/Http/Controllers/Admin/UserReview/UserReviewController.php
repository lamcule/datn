<?php

namespace Modules\Admin\Http\Controllers\Admin\UserReview;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ReviewExport;
use Modules\Mon\Entities\UserReview;
use Modules\Admin\Repositories\UserReviewRepository;
use Illuminate\Routing\Controller;

class UserReviewController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$userreviews = $this->userreview->all();

        return view('admin::userreviews.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::userreviews.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserReview $userreview
     * @return Response
     */
    public function edit(UserReview $userreview)
    {
        return view('admin::userreviews.edit', compact('userreview'));
    }
    public function download(Request $request)
    {
        $course_id = $request->get('course_id');
        $grade_id = $request->get('grade_id');
        $lesson_id = $request->get('lesson_id');
        return (new ReviewExport($course_id, $grade_id, $lesson_id))->download('review.xlsx');
    }

}
