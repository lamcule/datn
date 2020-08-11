<?php

namespace Modules\Mon\Http\Controllers;

class AdminController extends BaseController
{
    public function view($name, $data = [], $mergeData = [])
    {

        if (!strpos($name, '::')) {
            $namespace = 'backend';
            return view("$namespace::$name", $data, $mergeData);
        }
        return view($name, $data, $mergeData);
    }
}
