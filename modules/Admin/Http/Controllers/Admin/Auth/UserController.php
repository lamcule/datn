<?php

namespace Modules\Admin\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::auth.user.index');
    }
    public function create()
    {
        return view('admin::auth.user.create');
    }
    public function edit()
    {
        return view('admin::auth.user.edit');
    }
    public function destroy()
    {
        return view('admin::auth.user.index');
    }
}
