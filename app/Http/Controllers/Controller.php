<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function($request, $next){
            if (session('success')) {
                //Alert::success(session('success'));
                toast(session('success'), 'success', 'top-right');
            }

            if (session('error')) {
                //Alert::error(session('error'));
                toast(session('error'), 'error', 'top-right');
            }

            if (session('warning')) {
                //Alert::error(session('warning'));
                toast(session('warning'), 'warning', 'top-right');
            }

            return $next($request);
        });
    }
}
