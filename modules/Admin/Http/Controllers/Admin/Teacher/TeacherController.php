<?php

namespace Modules\Admin\Http\Controllers\Admin\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Mon\Auth\Contracts\Authentication;
use Modules\Mon\Entities\User;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$teachers = $this->teacher->all();

        return view('admin::teachers.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::teachers.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin::teachers.edit', compact('user'));
    }
}
