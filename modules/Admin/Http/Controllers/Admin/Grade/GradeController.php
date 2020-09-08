<?php

namespace Modules\Admin\Http\Controllers\Admin\Grade;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\GradeExport;
use Modules\Mon\Entities\Grade;
use Modules\Admin\Repositories\GradeRepository;
use Illuminate\Routing\Controller;

class GradeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('admin::grades.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::grades.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Grade $grade
     * @return Response
     */
    public function edit(Grade $grade)
    {
        return view('admin::grades.edit', compact('grade'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('admin::grades.view');
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
		return (new GradeExport($request))->download('grade.xlsx');
	}
}
