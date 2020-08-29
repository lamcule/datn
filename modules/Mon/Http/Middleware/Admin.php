<?php

namespace Modules\Mon\Http\Middleware;

use Closure;
use Modules\Mon\Auth\Contracts\Authentication;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Authentication $auth */
        $auth = app(Authentication::class);
        if (!$auth->check()) {
            return redirect()->guest(route('login.admin'))->withErrors('Vui lòng đăng nhập');
        }
        return $next($request);
    }
}
