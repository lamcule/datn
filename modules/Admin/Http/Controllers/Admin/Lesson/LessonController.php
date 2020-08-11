<?php

namespace Modules\Admin\Http\Controllers\Admin\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\LessonExport;
use Modules\Mon\Entities\Lesson;
use Modules\Admin\Repositories\LessonRepository;
use Illuminate\Routing\Controller;

class LessonController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$lessons = $this->lesson->all();

        return view('admin::lessons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::lessons.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Lesson $lesson
     * @return Response
     */
    public function edit(Lesson $lesson)
    {
        return view('admin::lessons.edit', compact('lesson'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin::lessons.view');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function qrcode()
    {
        //$lessons = $this->lesson->all();

        return view('admin::lessons.index');
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
		return (new LessonExport($request))->download('lesson.xlsx');
	}
}
