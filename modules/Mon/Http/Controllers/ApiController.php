<?php

namespace Modules\Mon\Http\Controllers;

use Modules\Mon\Auth\Contracts\Authentication;

class ApiController extends BaseController
{
    public function __construct(Authentication $auth)
    {
        parent::__construct($auth);
        $this->auth->setGuard('api');
    }
}
