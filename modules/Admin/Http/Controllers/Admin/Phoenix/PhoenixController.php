<?php

namespace Modules\Admin\Http\Controllers\Admin\Phoenix;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Phoenix;
use Modules\Admin\Repositories\PhoenixRepository;
use Illuminate\Routing\Controller;

class PhoenixController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$phoenixes = $this->phoenix->all();

        return view('admin::phoenixes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::phoenixes.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Phoenix $phoenix
     * @return Response
     */
    public function edit(Phoenix $phoenix)
    {
        return view('admin::phoenixes.edit', compact('phoenix'));
    }


}
