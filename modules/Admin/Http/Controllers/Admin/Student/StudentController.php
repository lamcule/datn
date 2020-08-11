<?php

namespace Modules\Admin\Http\Controllers\Admin\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Student;
use Modules\Admin\Repositories\StudentRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;

class StudentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$students = $this->student->all();

        return view('admin::students.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::students.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin::students.edit', compact('user'));
    }


}
