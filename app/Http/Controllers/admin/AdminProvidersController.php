<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use App\Trip;
use Illuminate\Http\Request;
use App\Provider;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProviderRegisterRequest;
use App\Service;
use Str;

class AdminProvidersController extends Controller
{
    public function index()
    {
        $providers = Provider::orderby('created_at', 'desc')->paginate('10');
        return view('dashboard.providers.index')->with('providers', $providers);
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
    public function edit($id)
    {
        $provider = provider::findOrFail($id);

        return view('dashboard.providers.edit')->with('provider', $provider);
    }
    public function create()
    {
        $services = Service::all();
        return view('dashboard.providers.create', ['services' => $services]);
    }
    public function create_haj()
    {
        return view('dashboard.providers.create_haj');
    }
    protected function store_haj(ProviderRegisterRequest $request)
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
                return redirect()->route('dashboard.providers.create')->with('error', 'رقم الجوال السعودي موجود بنظام   ')->withInput();
            }
        }
        if ($request->y_phone) {
            if (Provider::where('y_phone', $phoneProv)->first()) {
                return redirect()->route('dashboard.providers.create')->with('error', 'رقم الجوال اليمني موجود بنظام   ')->withInput();
            }
        }




        $provider = new Provider();
        $provider->password = Hash::make($request['password']);
        $provider->name_company = $request['name_company'];
        $provider->haj = $request['haj'];
        $provider->city = $request['city'];
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



        return redirect(route('dashboard.providers.index'))->with('success', 'تم اضافة  مزود بنجاح');
    }


    protected function store(ProviderRegisterRequest $request)
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
                return redirect()->route('dashboard.providers.create')->with('error', 'رقم الجوال السعودي موجود بنظام   ')->withInput();
            }
        }
        if ($request->y_phone) {
            if (Provider::where('y_phone', $phoneProv)->first()) {
                return redirect()->route('dashboard.providers.create')->with('error', 'رقم الجوال اليمني موجود بنظام   ')->withInput();
            }
        }




        $provider = new Provider();
        $provider->password = Hash::make($request['password']);
        $provider->name_company = $request['name_company'];
        $provider->service_id = $request['service_id'];
        $provider->city = $request['city'];
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



        return redirect(route('dashboard.providers.index'))->with('success', 'تم اضافة  مزود بنجاح');
    }






    public function update(Request $request, $id)
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


        $provider->save();

        return redirect(route('dashboard.providers.index'))->with('success', 'تم تعديل الحساب بنجاح');
    }

    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        return redirect(route('dashboard.providers.index'));
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
    public function smsProvider($id)
    {

        $Provider = Provider::where('id', $id)->first();

        return view('dashboard.providers.smsProvider')->with(['provider' => $Provider]);
    }

    public function storeSmsP(Request $request)
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



        return redirect(route('dashboard.providers.index'))->with('success', ' تم  ارسال الرساله');
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
