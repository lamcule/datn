<?php

namespace Modules\Admin\Http\Controllers\Admin\QuestionGroup;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\QuestionGroup;
use Modules\Admin\Repositories\QuestionGroupRepository;
use Illuminate\Routing\Controller;

class QuestionGroupController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$questiongroups = $this->questiongroup->all();

        return view('admin::questiongroups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::questiongroups.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  QuestionGroup $questiongroup
     * @return Response
     */
    public function edit(QuestionGroup $questiongroup)
    {
        return view('admin::questiongroups.edit', compact('questiongroup'));
    }


}
