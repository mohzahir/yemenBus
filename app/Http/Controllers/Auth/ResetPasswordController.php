<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
 use Illuminate\Support\Facades\Password;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
     

 public function broker()
    {
        return Password::broker(request()->get('user-type'));
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'user_type' => $request->user_type]
        );
    }



  protected function reset(Request $request)
    {
        $user=Admin::first();
        $user->password = Hash::make($request->password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        //event(new PasswordReset($user));

        return redirect('login/admin')->with(['url'=>'admin','success'=>"تم استعادة كلمه المرور بنجاح"]);
    }


}
