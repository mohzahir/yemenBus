<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use App\Trip;
use Illuminate\Http\Request;
use App\Provider;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProviderRegisterRequest;
use Str;

class AdminProvider_carController extends Controller
{


    public function provider_car()
    {
        $Provider_car = Provider::where('car', 1)->orderby('created_at', 'desc')->paginate('10');
        return view('dashboard.providers.provider_car')->with('Provider_car', $Provider_car);
    }
    public function pfar()
    {
        $pfas = DB::table('power_financial_agents')->orderby('created_at', 'desc')->paginate(10);
        return view('dashboard.providers.pfar')->with('pfas', $pfas);
    }


    public function noms()
    {


        $noms = DB::table('noms')->orderby('id', 'desc')->paginate(10);


        return view('dashboard.providers.nomOfMarketer')->with(['noms' => $noms]);
    }
    public function edit_car($id)
    {
        $provider = Provider::findOrFail($id);

        return view('dashboard.providers.edit_car')->with('provider', $provider);
    }
    public function create_car()
    {
        return view('dashboard.providers.create_car');
    }

    protected function store_car(ProviderRegisterRequest $request)
    {
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
        if ($request->phone && $request->y_phone) {
            return redirect()->back()->with('error', 'يرجى ادخال احد الرقمين')->withInput();
        }
        if ($request->phone) {
            if (Provider::where('phone', $phone)->first()) {
                return redirect()->route('dashboard.providers.create_car')->with('error', 'رقم الجوال السعودي موجود بنظام   ')->withInput();
            }
        }
        if ($request->y_phone) {
            if (Provider::where('y_phone', $phoneProv)->first()) {
                return redirect()->route('dashboard.providers.create_car')->with('error', 'رقم الجوال اليمني موجود بنظام   ')->withInput();
            }
        }




        $provider = new Provider();
        $provider->password = Hash::make($request['password']);
        $provider->name_company = $request['name_company'];
        $provider->city = $request['city'];
        $provider->person_number = $request['person_number'];
        $provider->car_number = $request['car_number'];
        $provider->type_service = json_encode($request['type_service']);
        $type_services = json_decode($provider->type_service);

        foreach ($type_services as  $value) {
            if ($value == 3 || $value == 4) {
                $provider->msg = 1;
            }
            else{
                $provider->msg = 0;
            }
        }
        // var_dump($provider->msg);exit();

        if ($request->hasFile('person_img') && $request->file('person_img')->isValid()) {

            $imageName = time().'.'.$request->file('person_img')->extension();  
            $destinationPath =  $request->file('person_img')->move(public_path('images'), $imageName);
            $url = '/public/images/' . $imageName;
            $provider->person_img =$url;

        }
        if ($request->hasFile('car_img') && $request->file('car_img')->isValid()) {

            $imageName = time().'.'.$request->file('car_img')->extension();  
            $destinationPath =  $request->file('car_img')->move(public_path('images'), $imageName);
            $url = '/public/images/' . $imageName;
            $provider->car_img =$url;

        }
        $provider->car = 1;
        $body = 'مبروك عليك تم اضافتك كمزود كلمه السر :' . $request->password . 'رابط تسجيل  رابط ادارتك : https://dashboard.yemenbus.com/login/provider';

        if ($request->y_phone) {
            $provider->y_phone = $phoneProv;
            $to = $provider->y_phone;
            $this->sendYESMS($to, $body);
        }
        if ($request->phone) {
            $provider->phone = $phone;
            $to = $provider->phone;
            $this->sendSASMS($to, $body);
        }
        $provider->save();

        // dd($provider->person_img);


        return redirect(route('dashboard.providers.provider_car'))->with('success', 'تم اضافة  مزود بنجاح');
    }






    public function update_car(Request $request, $id)
    {
        request()->validate([
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],

            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],

            'name_company' => ['required', 'string', 'max:255'],

        ], [
            'name_company.required' => ' يرجى ادخال اسم الشركة',

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',

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

        $provider = Provider::findOrFail($id);
        $provider->name_company = $request->name_company;
        $provider->phone = $phone;
        $provider->y_phone = $phoneProv;
        $provider->person_number = $request['person_number'];
        $provider->car_number = $request['car_number'];
        $provider->type_service =json_encode( $request['type_service']);

        $provider->save();

        return redirect(route('dashboard.providers.provider_car'))->with('success', 'تم تعديل الحساب بنجاح');
    }

    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        return redirect(route('dashboard.providers.provider_car'));
    }
    public function destroyPfa($id)
    {
        $pfas = DB::table('power_financial_agents')->where('id', $id)->delete();

        return redirect(route('dashboard.providers.pfar'));
    }
    public function trips()
    {
        $trips = Trip::paginate(5);
        return view('dashboard.providers.trips')->with('trips', $trips);
    }
    public function smsProvider_car($id)
    {

        $Provider = Provider::where('id', $id)->first();

        return view('dashboard.providers.smsProvider_car')->with(['provider' => $Provider]);
    }

    public function storeSmsP_car(Request $request)
    {
        request()->validate([
            'phone' => ['regex:/^(009665|9665|\+9665|05)([0-9]{8})$/i', 'required_without:y_phone', 'nullable'],

            'y_phone' => ['regex:/^(009677|9677|\+9677|7)([0-9]{8})$/i', 'required_without:phone', 'nullable'],


        ], [

            'phone.regex' => 'الرقم غير صحيح',
            'phone.required_without' => 'يجب ادخال احد الرقمين',
            'y_phone.regex' => 'الرقم غير صحيح',
            'y_phone.required_without' => 'يجب ادخال احد الرقمين',

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

        $msg = $request->message;
        if ($request->phone) {
            $to = $request->phone;
            $this->sendSASMS($to, $msg);
        }
        if ($request->y_phone) {
            $to = $request->y_phone;
            $this->sendYESMS($to, $msg);
        }



        return redirect(route('dashboard.providers.provider_car'))->with('success', ' تم  ارسال الرساله');
        //


    }




    function sendSASMS($to, $body)
    {
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
    function sendYESMS($to, $body)
    {
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
