<?php

namespace App\Http\Controllers\Auth;

use Str;
use App\Bank;
use App\User;
use App\Address;
use App\Marketer;
use App\Provider;
use App\Passenger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MarketerRegisterRequest;
use App\Http\Requests\ProviderRegisterRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\PassengerRegisterRequest;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
        $this->middleware('guest:marketer');
        $this->middleware('guest:provider');
        $this->middleware('guest:passenger');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone'=>['required,email'],
            'password'=>['required'],
            'name'=>['required'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createAdmin(Request $request)
    {
        $this->validator($request->all())->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/admin');
    }


    protected function createMarketer(MarketerRegisterRequest $request)
    {
       $marketer = new Marketer();
      $marketer->name=$request['name'];
      $marketer->password = Hash::make($request['password']);
      $marketer->code=str_pad(rand(0,999), 3, "0", STR_PAD_LEFT);
      if($request->passenger_phone_yem){ $marketer->y_phone=$request['y_phone'];}
              $marketer->save();

      if($request->phone){
       $marketer->phone=$request['phone'];
       $to= $marketer->phone;
              $body='مبروك عليك تم اضافتك كمسوق .اكسب مع يمن باص الفلوس كمسوق لتذاكر والخدمات السفر من والى اليمن  كلمه السر :'.$request->password.'رابط نسجيل  رابط ادارتك : https://dashboard.yemenbus.com/login/marketer';
           $this->sendSASMS($to,$body);

        }
        if($request->y_phone){
            $to= $request->y_phone;
                    $body='مبروك عليك تم اضافتك كمسوق .اكسب مع يمن باص الفلوس كمسوق لتذاكر والخدمات السفر من والى اليمن  كلمه السر :'.$request->password.'رابط نسجيل  رابط ادارتك : https://dashboard.yemenbus.com/login/marketer';
                $this->sendYESMS($request->y_phone,$body);

        }
        
        return redirect()->intended('login/marketer');
    }

    protected function createProvider(ProviderRegisterRequest $request)
    {
        //$this->validator($request->all())->validate();
        /*$provider = Provider::create([
            'name_company' => $request['name_company'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
        ]);*/
            $provider = new Provider();
        $provider->password = Hash::make($request['password']);
        $provider->name_company= $request['name_company'];
        if($request->passenger_phone_yem){ $provider->y_phone=$request['y_phone'];}
                $provider->save();

        if($request->phone){
        $provider->phone=$request['phone'];
        $to= $provider->phone;
                $body='مبروك عليك تم اضافتك كمزود كلمه السر :'.$request->password.'رابط نسجيل  رابط ادارتك : https://dashboard.yemenbus.com/login/provider';
        
                    $this->sendSASMS($request->phone,$body);

        }
            if($request->y_phone){
            $to= $request->y_phone;
                    $body='مبروك عليك تم اضافتك كمزود كلمه السر :'.$request->password.'رابط نسجيل  رابط ادارتك : https://dashboard.yemenbus.com/login/provider';
                $this->sendYESMS($request->y_phone,$body);

        }

       
        return redirect()->intended('login/provider');
    }


    protected function createPassenger(PassengerRegisterRequest $request)
    {
            $passenger = new Passenger();
        $passenger->password = Hash::make($request['password']);
        $passenger->name_passenger= $request['name_passenger'];

        if($request->passenger_phone_yem)
        {
             $passenger->y_phone = $request['y_phone'];
        }
        if($request->phone)
        {
             $passenger->phone = $request['phone'];
        }
        $passenger->save();

       
        return redirect()->intended('login/passenger');
    }


    public function showAdminRegisterForm()
    {
        return view('auth.register', ['url' => 'admin']);
    }

    public function showMarketerRegisterForm()
    {
        return view('auth.register', ['url' => 'marketer']);
    }

    public function showProviderRegisterForm()
    {
        return view('auth.register', ['url' => 'provider']);
    }
    public function showPassengerRegisterForm()
    {
        return view('auth.register', ['url' => 'passenger']);
    }
    
 function sendSASMS($to, $body) {
        $client = new \GuzzleHttp\Client();
        $client->get('http://www.4jawaly.net/api/sendsms.php', [
            'query' => [
                'username' => env('SAUDI_SMS_username'),
                'password' => env('SAUDI_SMS_password'),
                'sender'  => env('SAUDI_SMS_sender'),
                'numbers' => $to,
                'message' => $body,
                'unicode' => 'E',
            ]
        ]);
    }
        function sendYESMS($to, $body) {
    $client = new \GuzzleHttp\Client();
    $client->get('http://52.36.50.145:8080/MainServlet', [
        'query' => [
            'orgName' => env('YEMEN_SMS_orgName'),
            'userName' => env('YEMEN_SMS_userName'),
            'password' => env('YEMEN_SMS_password'),
            'mobileNo' => $to,
            'text' => $body,
            'coding' => 2,
        ]
    ]);
}



}
