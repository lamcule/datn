<?php

namespace Modules\Admin\Http\Controllers\Admin\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Mon\Entities\Review;
use Modules\Admin\Repositories\ReviewRepository;
use Illuminate\Routing\Controller;

class ReviewController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$reviews = $this->review->all();

        return view('admin::reviews.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::reviews.create');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  Review $review
     * @return Response
     */
    public function edit(Review $review)
    {
        return view('admin::reviews.edit', compact('review'));
    }


}
