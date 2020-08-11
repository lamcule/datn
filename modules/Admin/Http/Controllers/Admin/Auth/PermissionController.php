<?php

namespace Modules\Admin\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::auth.permission.index');
    }
    public function create()
    {
        return view('admin::auth.permission.create');
    }
    public function edit()
    {
        return view('admin::auth.permission.edit');
    }

}
