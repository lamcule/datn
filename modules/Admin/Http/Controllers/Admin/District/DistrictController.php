<?php

namespace Modules\Admin\Http\Controllers\Admin\District;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\District;
use Modules\Admin\Repositories\DistrictRepository;
use Illuminate\Routing\Controller;

class DistrictController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$districts = $this->district->all();

        return view('admin::districts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::districts.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  District $district
     * @return Response
     */
    public function edit(District $district)
    {
        return view('admin::districts.edit', compact('district'));
    }


}
