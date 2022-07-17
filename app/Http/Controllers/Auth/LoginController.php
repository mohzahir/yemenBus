<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\Hash;
use App\Lab;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:marketer')->except('logout');
        $this->middleware('guest:provider')->except('logout');
        $this->middleware('guest:lab')->except('logout');
        $this->middleware('guest:passenger')->except('logout');
    }

    public function showAdminLoginForm()
    {

        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:3'
        ], [

            'email.required' => 'يرجى ادخال  البريد الاكتروني',
            'password.required' => 'يرجى ادخال كلمة السر',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/dashboard/admin');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function showmarketerLoginForm()
    {
        return view('auth.login', ['url' => 'marketer']);
    }
    public function showPassengerLoginForm()
    {
        return view('auth.login', ['url' => 'passenger']);
    }

    public function passengerLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],
            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],
            'password' => 'required'

        ], [

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',
            'password.required' => 'يرجى ادخال كلمة السر',
        ]);

        $phone = "";
        if ($request->phone) {
            $into = Str::substr($request->phone, 0, 2);

            if ($into == '05') {
                $phoneM = Str::substr($request->phone, 2, 8);

                $phone = "9665" . $phoneM;
            } else {
                $phone = $request->phone;
            }
        }
        $phoneProv = "";
        if ($request->y_phone) {
            $into = Str::substr($request->y_phone, 0, 1);

            if ($into == '7') {
                $phoneP = Str::substr($request->y_phone, 1, 8);

                $phoneProv = "9677" . $phoneP;
            } else {
                $phoneProv = $request->y_phone;
            }
        }


        if (Auth::guard('passenger')->attempt(
            ['phone' =>  $phone, 'password' => $request->password],
            $request->get('remember')
        ) || Auth::guard('passenger')->attempt([
            'y_phone' => $phoneProv,
            'password' => $request->password
        ], $request->get('remember'))) {

            return redirect()->intended('/passengers');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function marketerLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],
            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],
            'password' => 'required'

        ], [

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',
            'password.required' => 'يرجى ادخال كلمة السر',
        ]);

        $phone = "";
        if ($request->phone) {
            $into = Str::substr($request->phone, 0, 2);

            if ($into == '05') {
                $phoneM = Str::substr($request->phone, 2, 8);

                $phone = "9665" . $phoneM;
            } else {
                $phone = $request->phone;
            }
        }
        $phoneProv = "";
        if ($request->y_phone) {
            $into = Str::substr($request->y_phone, 0, 1);

            if ($into == '7') {
                $phoneP = Str::substr($request->y_phone, 1, 8);

                $phoneProv = "9677" . $phoneP;
            } else {
                $phoneProv = $request->y_phone;
            }
        }


        if (Auth::guard('marketer')->attempt(
            ['phone' =>  $phone, 'state' =>  'active', 'password' => $request->password],
            $request->get('remember')
        ) || Auth::guard('marketer')->attempt(['y_phone' => $phoneProv, 'state' =>  'active', 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/marketers/archive');
        }
        return back()->withInput($request->only('email', 'remember'));
    }


    public function showProviderLoginForm()
    {
        return view('auth.login', ['url' => 'provider']);
    }

    public function providerLogin(Request $request)
    {


        // dd($request);


        $this->validate($request, [
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],

            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],


            'password' => 'required'
        ], [

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',
            'password.required' => 'يرجى ادخال كلمة السر',
        ]);
        $phone = "";
        if ($request->phone) {
            $into = Str::substr($request->phone, 0, 2);

            if ($into == '05') {
                $phoneM = Str::substr($request->phone, 2, 8);

                $phone = "9665" . $phoneM;
            } else {
                $phone = $request->phone;
            }
        }
        $phoneProv = "";
        if ($request->y_phone) {
            $into = Str::substr($request->y_phone, 0, 1);

            if ($into == '7') {
                $phoneP = Str::substr($request->y_phone, 1, 8);

                $phoneProv = "9677" . $phoneP;
            } else {
                $phoneProv = $request->y_phone;
            }
        }

        if ($phone) {


            if (Auth::guard('provider')->attempt(['phone' => $phone, 'password' => $request->password], $request->get('remember'))) {

                return redirect()->intended('/provider/dashboard');
            }
        } elseif ($phoneProv) {
            if (Auth::guard('provider')->attempt(['y_phone' => $phoneProv, 'password' => $request->password], $request->get('remember'))) {

                return redirect()->intended('/provider/dashboard');
            }
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function showLabLoginForm()
    {
        return view('auth.login', ['url' => 'lab']);
    }

    public function labLogin(Request $request)
    {


        $this->validate($request, [
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required'],

            //'y_phone'=>['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i','required_without:phone','nullable'],


            'password' => 'required'
        ], [

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required' => 'يجب ادخال الرقم ',
            'password.required' => 'يرجى ادخال كلمة السر',
        ]);

        $phone = "";
        if ($request->phone) {
            $into = Str::substr($request->phone, 0, 2);

            if ($into == '05') {
                $phoneM = Str::substr($request->phone, 2, 8);

                $phone = "9665" . $phoneM;
            } else {
                $phone = $request->phone;
            }
        }
        /*if($request->y_phone){
    $into=Str::substr($request->y_phone,0,1);
    
    if($into=='7'){
    $phoneP=Str::substr($request->y_phone,1,8);
      
    $phoneProv="9677".$phoneP;
   
}else{
    $phoneProv=$request->y_phone;
}
}
          
 */
        $lab = Lab::where('phone', $phone)->first();
        if ($lab && Hash::check($request->password, $lab->password)) {
            Auth::guard('lab')->login($lab);
            return redirect()->intended('/dashboard/lab/index');
        }

        return back()->withInput($request->only('phone', 'remember'));
        /*if (Auth::guard('lab')->attempt(['phone' =>  $phone, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/dashboard/lab/index');
        }*/
        //return back()->withInput($request->only('phone','remember'));
    }


    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) // this means that the admin was logged in.
        {
            Auth::guard('admin')->logout();
            return redirect('/login/admin')->with('url', 'admin');
        }
        if (Auth::guard('marketer')->check()) // this means that the admin was logged in.
        {
            Auth::guard('marketer')->logout();
            return redirect('/login/marketer')->with('url', 'marketer');
        }
        if (Auth::guard('provider')->check()) // this means that the admin was logged in.
        {
            Auth::guard('provider')->logout();
            return redirect('/login/provider')->with('url', 'provider');
        }
        if (Auth::guard('passenger')->check()) // this means that the passenger was logged in.
        {
            Auth::guard('passenger')->logout();
            return redirect('/login/passenger')->with('url', 'passenger');
        }
        if (Auth::guard('lab')->check()) // this means that the admin was logged in.
        {
            Auth::guard('lab')->logout();
            return redirect('/login/lab')->with('url', 'lab');
        }

        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
    public function username()
    {
        return 'phone';
    }
    /*
    public function logoutMarketer(Request $request){

      Auth::guard('marketer')->logout();
        return  redirect('/login/marketer');

    }

    public function logoutProvider(Request $request){
Auth::guard('provider')->logout();
        return  redirect('/login/provider');


    }


    public function logoutAdmin(Request $request){
    Auth::guard('admin')->logout();
        return redirect('/login/admin');


    }*/
}
