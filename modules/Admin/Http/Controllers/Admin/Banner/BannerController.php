<?php

namespace Modules\Admin\Http\Controllers\Admin\Banner;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Banner;
use Modules\Admin\Repositories\BannerRepository;
use Illuminate\Routing\Controller;

class BannerController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$banners = $this->banner->all();

        return view('admin::banners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::banners.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Banner $banner
     * @return Response
     */
    public function edit(Banner $banner)
    {
        return view('admin::banners.edit', compact('banner'));
    }


}
