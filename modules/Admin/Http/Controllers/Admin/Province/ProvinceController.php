<?php

namespace Modules\Admin\Http\Controllers\Admin\Province;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Province;
use Modules\Admin\Repositories\ProvinceRepository;
use Illuminate\Routing\Controller;

class ProvinceController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$provinces = $this->province->all();

        return view('admin::provinces.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::provinces.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Province $province
     * @return Response
     */
    public function edit(Province $province)
    {
        return view('admin::provinces.edit', compact('province'));
    }


}
