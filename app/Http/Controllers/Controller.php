<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    use AuthorizesRequests {
        authorize as protected baseAuthorize;
    }

    public function authorize($ability, $arguments = [])
    {
        
        if (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
        }elseif(Auth::guard('marketer')->check()) {
            Auth::shouldUse('marketer');
        }elseif(Auth::guard('provider')->check()) {
            Auth::shouldUse('provider');
        }elseif(Auth::guard('lab')->check()) {
            Auth::shouldUse('lab');
        }

        $this->baseAuthorize($ability, $arguments);
    }
}
