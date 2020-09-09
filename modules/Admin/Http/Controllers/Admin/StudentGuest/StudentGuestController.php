<?php

namespace Modules\Admin\Http\Controllers\Admin\StudentGuest;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Repositories\StudentGuestRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;

class StudentGuestController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$studentguests = $this->studentguest->all();

        return view('admin::studentguests.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::studentguests.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $studentguest
     * @return Response
     */
    public function edit(User $studentguest)
    {
        return view('admin::studentguests.edit', compact('studentguest'));
    }


}
