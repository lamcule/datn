<?php

namespace Modules\Admin\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::auth.role.index');
    }
    public function create()
    {
        return view('admin::auth.role.create');
    }
    public function edit()
    {
        return view('admin::auth.role.edit');
    }

}
