<?php

namespace Modules\Admin\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Http\Controllers\AdminController;

class HomeController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return $this->view('admin::index');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function lesson()
    {
        return $this->view('admin::lesson');
    }
    public function checkinQR(Lesson $lesson)
    {
        return $this->view('admin::checkinqr', compact('lesson'));
    }
    public function checkoutQR(Lesson $lesson)
    {
        return $this->view('admin::checkoutqr', compact('lesson'));
    }
    public function reviewQR(Lesson $lesson)
    {
        return $this->view('admin::reviewqr', compact('lesson'));
    }
}
