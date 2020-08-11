<?php

namespace Modules\Admin\Http\Controllers\Admin\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\CourseExport;
use Modules\Mon\Entities\Course;
use Modules\Admin\Repositories\CourseRepository;
use Illuminate\Routing\Controller;

class CourseController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$courses = $this->course->all();

        return view('admin::courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::courses.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Course $course
     * @return Response
     */
    public function edit(Course $course)
    {
        return view('admin::courses.edit', compact('course'));
    }
    /**
     * Show the .
     *
     * @return Response
     */
    public function view()
    {
        return view('admin::courses.view');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function destroy()
    {
        //$courses = $this->course->all();

        return $this->view('admin::index');
    }
    public function download(Request $request)
    {
        return (new CourseExport($request))->download('activity.xlsx');
    }
}
