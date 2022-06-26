<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
namespace App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketerController
{
    protected $redirectTo = 'marketers/archive';
   
    public function showLoginForm()
    {
        return view('auth.login.marketer');
    }
    public function username()
{
    return 'marketer_name';
}
    protected function guard()
    {
        return Auth::guard('marketer');
    }

        

}




