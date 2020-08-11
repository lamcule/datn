<?php

namespace Modules\Admin\Http\Controllers\Admin\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Question;
use Modules\Admin\Repositories\QuestionRepository;
use Illuminate\Routing\Controller;

class QuestionController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$questions = $this->question->all();

        return view('admin::questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::questions.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question $question
     * @return Response
     */
    public function edit(Question $question)
    {
        return view('admin::questions.edit', compact('question'));
    }


}
