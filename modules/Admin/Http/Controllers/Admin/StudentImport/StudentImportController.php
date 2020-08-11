<?php

namespace Modules\Admin\Http\Controllers\Admin\StudentImport;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\StudentImport;
use Modules\Admin\Repositories\StudentImportRepository;
use Illuminate\Routing\Controller;

class StudentImportController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$studentimports = $this->studentimport->all();

        return view('admin::studentimports.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function view()
    {


        return view('admin::studentimports.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::studentimports.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  StudentImport $studentimport
     * @return Response
     */
    public function edit(StudentImport $studentimport)
    {
        return view('admin::studentimports.edit', compact('studentimport'));
    }


}
