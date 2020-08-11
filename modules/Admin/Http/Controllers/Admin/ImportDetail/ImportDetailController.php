<?php

namespace Modules\Admin\Http\Controllers\Admin\ImportDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\ImportDetail;
use Modules\Admin\Repositories\ImportDetailRepository;
use Illuminate\Routing\Controller;

class ImportDetailController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$importdetails = $this->importdetail->all();

        return view('admin::importdetails.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::importdetails.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  ImportDetail $importdetail
     * @return Response
     */
    public function edit(ImportDetail $importdetail)
    {
        return view('admin::importdetails.edit', compact('importdetail'));
    }


}
