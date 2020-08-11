<?php

namespace Modules\Admin\Http\Controllers\Admin\UserLesson;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\CheckInOutExport;
use Modules\Mon\Entities\UserLesson;
use Modules\Admin\Repositories\UserLessonRepository;
use Illuminate\Routing\Controller;

class UserLessonController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin::userlessons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::userlessons.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserLesson $userlesson
     * @return Response
     */
    public function edit(UserLesson $userlesson)
    {
        return view('admin::userlessons.edit', compact('userlesson'));
    }
    public function download(Request $request)
    {
        $course_id = $request->get('course_id');
        $grade_id = $request->get('grade_id');
        $lesson_id = $request->get('lesson_id');
        return (new CheckInOutExport($request))->download('checkinout.xlsx');

    }


}
