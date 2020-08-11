<?php

namespace Modules\Admin\Http\Controllers\Admin\UploadStudent;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\UploadStudent;
use Modules\Admin\Repositories\UploadStudentRepository;
use Illuminate\Routing\Controller;

class UploadStudentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$uploadstudents = $this->uploadstudent->all();

        return view('admin::uploadstudents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::uploadstudents.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  UploadStudent $uploadstudent
     * @return Response
     */
    public function edit(UploadStudent $uploadstudent)
    {
        return view('admin::uploadstudents.edit', compact('uploadstudent'));
    }


}
