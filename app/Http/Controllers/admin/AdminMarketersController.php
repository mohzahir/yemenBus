<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Marketer;
use Illuminate\Http\Request;
use DB;
use App\Provider;
use App\Sms;
use App\Http\Requests\SmsRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\MarketerRegisterRequest;
use App\Service;
use Str;


class AdminMarketersController extends Controller
{
    public function index(Request $request)
    {
        $marketers = Marketer::when($request->provider_id, function ($q) use ($request) {
            $q->where('provider_id');
        })
            ->orderby('created_at', 'desc')->paginate('10');
        $providers = Provider::all();
        return view('dashboard.marketers.index')->with([
            'marketers' => $marketers,
            'providers' => $providers
        ]);
    }
    public function show($id)
    {
        $marketer = Marketer::findOrFail($id);

        return view('dashboard.marketers.info')->with('marketer', $marketer);
    }

    public function create()
    {
        $providers = Provider::all();
        $services = Service::all();
        return view('dashboard.marketers.create', [
            'providers' => $providers,
            'services' => $services,
        ]);
    }
    public function edit($id)
    {
        $marketer = Marketer::findOrFail($id);

        return view('dashboard.marketers.update')->with('marketer', $marketer);
    }


    public function store(MarketerRegisterRequest $request)
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
            if (Marketer::where('phone', $phone)->first()) {
                return redirect()->route('dashboard.marketers.create')->with('error', 'رقم الجوال السعودي موجود بنظام   ')
                    ->withInput();
            }
        }
        if ($request->y_phone) {
            if (Marketer::where('y_phone', $phoneProv)->first()) {
                return redirect()->route('dashboard.marketers.create')->with('error', 'رقم الجوال اليمني موجود بنظام   ')->withInput();
            }
        }
        if (Marketer::where('name', $request->name)->first()) {
            return redirect()->route('dashboard.marketers.create')->with('error', 'اسم المسوق موجود بنظام')->withInput();
        }

        $marketer = new Marketer();
        $marketer->name = $request['name'];
        $marketer->marketer_type = $request['marketer_type'];
        $marketer->provider_id = $request['provider_id'] ?? null;
        $marketer->service_id = $request['service_id'] ?? null;
        $marketer->password = Hash::make($request['password']);
        // $marketer->code = str_pad(rand(0, 999), 3, "0", STR_PAD_LEFT);
        $body = 'مبروك عليك تم اضافتك كمسوق .اكسب مع يمن باص الفلوس كمسوق لتذاكر والخدمات السفر من والى اليمن  كلمه السر :' . $request->password . 'رابط نسجيل  رابط ادارتك : https://yemenbus.com/login/marketer';

        if ($request->y_phone) {
            $marketer->y_phone = $phoneProv;
            $to = $marketer->y_phone;
            $this->sendYESMS($request->y_phone, $body);
        }

        if ($request->phone) {
            $marketer->phone = $phone;
            $to = $marketer->phone;

            $this->sendSASMS($to, $body);
        }

        $marketer->save();



        return redirect(route('dashboard.marketers.index'))->with('success', 'تم اضافة  المسوق بنجاح');
    }

    public function update(Request $request, $id)
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
        $marketer = Marketer::findOrFail($id);
        $marketer->update([
            'state' => $request->state,
            'provide' => $request->provide,
            'max_rs' => $request->max_rs,
            'max_ry' => $request->max_ry,
            'tip_rs' => $request->tip_rs,
            'tip_ry' => $request->tip_ry,

        ]);
        if ($request->phone) {
            $marketer->phone = $phone;
        } else {
            $marketer->y_phone = $phoneProv;
        }
        $marketer->save();

        return redirect(route('dashboard.marketers.index'))->with('success', 'تم تعديل بنجاح');
    }

    public function destroy($id)
    {
        $marketer = Marketer::findOrFail($id);
        $marketer->delete();

        return redirect(route('dashboard.marketers.index'))->with('success', 'تم الحذف  بنجاح');
    }

    public function toActive($id)
    {
        $marketer = Marketer::findOrFail($id);
        $marketer->update(['state' => 'active']);
        $marketer->save();


        return back();
    }


    public function sms($id)
    {


        $pfa = DB::table('power_financial_agents')->where('id', $id)->first();
        $provider = Provider::where('id', $pfa->provider_id)->first();
        $marketer = Marketer::where('code', $pfa->code)->first();
        return view('dashboard.marketers.sms')->with(['pfa' => $pfa, 'provider_name' => $provider->name_company, 'marketer' => $marketer]);
    }

    public function storeSms(SmsRequest $request)
    {
        $phone = "";
        if ($request->passenger_phone) {
            $into = Str::substr($request->passenger_phone, 0, 2);

            if ($into == '05') {
                $phoneM = Str::substr($request->passenger_phone, 2, 8);

                $phone = "9665" . $phoneM;
            } else {
                $phone = $request->passenger_phone;
            }
        }
        $phoneProv = "";
        if ($request->passenger_phone_yem) {
            $into = Str::substr($request->passenger_phone_yem, 0, 1);

            if ($into == '7') {
                $phoneP = Str::substr($request->passenger_phone_yem, 1, 8);

                $phoneProv = "9677" . $phoneP;
            } else {
                $phoneProv = $request->passenger_phone_yem;
            }
        }

        Sms::create($request->all());
        $msg = $request->message;
        if ($request->passenger_phone) {
            $to = $phone;

            $this->sendSASMS($request->passenger_phone, $msg);
        } else {
            $to = $phoneProv;
            $this->sendYESMS($request->passenger_phone_yem, $msg);
        }
        return redirect()
            ->back()
            ->with('success', ' تم  ارسال الرساله');
        //


    }

    public function smsMarketer($id)
    {
        $m = Marketer::where('id', $id)->first();
        return view('dashboard.marketers.smsMarketer')->with('marketer', $m);
    }

    public function storeSmsM(Request $request)
    {
        $msg = $request->message;
        if ($request->phone) {
            $to = $request->phone;
            $this->sendSASMS($to, $msg);
        }
        if ($request->y_phone) {
            $to = $request->y_phone;
            $this->sendYESMS($to, $msg);
        }


        return redirect(route('dashboard.marketers.index'))->with('success', ' تم  ارسال الرساله');
        //


    }





    public function toSuspend($id)
    {
        $marketer = Marketer::findOrFail($id);
        if ($marketer->state == 'active') {
            $marketer->update(['state' => 'suspended']);
            $marketer->save();
        }

        return back();
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
