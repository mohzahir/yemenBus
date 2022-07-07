<?php

namespace App\Http\Controllers\Provider;

// use App\Http\Controllers\Controller;

use App\Http\Requests\MarketerRegisterRequest;
use App\Marketer;
use App\Provider;
use App\Recharge;
use App\Reseervation;
use App\Service;
use App\Setting;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MarketersController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $marketers = Marketer::where('provider_id', auth()->guard('provider')->user()->id)->get();
        return view('providers.marketers.index', compact('marketers'));
    }

    public function show($reservation)
    {
        $reservation = Reseervation::findOrFail($reservation);
        // dd($reservation);

        return view('providers.haj-reservation.show', ['reservation' => $reservation]);
    }

    public function create()
    {
        $providers = Provider::all();
        $services = Service::all();
        return view('providers.marketers.create', [
            'providers' => $providers,
            'services' => $services,
        ]);
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
                return redirect()->route('provider.marketers.create')->with('error', 'رقم الجوال السعودي موجود بنظام   ')
                    ->withInput();
            }
        }
        if ($request->y_phone) {
            if (Marketer::where('y_phone', $phoneProv)->first()) {
                return redirect()->route('provider.marketers.create')->with('error', 'رقم الجوال اليمني موجود بنظام   ')->withInput();
            }
        }
        if (Marketer::where('name', $request->name)->first()) {
            return redirect()->route('provider.marketers.create')->with('error', 'اسم المسوق موجود بنظام')->withInput();
        }

        $marketer = new Marketer();
        $marketer->name = $request['name'];
        $marketer->marketer_type = 'provider_marketer';
        $marketer->provider_id = auth()->guard('provider')->user()->id;
        $marketer->service_id = null;
        $marketer->password = Hash::make($request['password']);
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



        return redirect(route('provider.marketers.index'))->with('success', 'تم اضافة  المسوق بنجاح');
    }

    public function edit($id)
    {
        $marketer = Marketer::findOrFail($id);

        return view('providers.marketers.update')->with('marketer', $marketer);
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
            'name' => $request->name,
            'state' => $request->state,
            // 'provide' => $request->provide,
            // 'max_rs' => $request->max_rs,
            // 'max_ry' => $request->max_ry,
            // 'tip_rs' => $request->tip_rs,
            // 'tip_ry' => $request->tip_ry,

        ]);
        if ($request->phone) {
            $marketer->phone = $phone;
        } else {
            $marketer->y_phone = $phoneProv;
        }
        $marketer->save();

        return redirect(route('provider.marketers.index'))->with('success', 'تم تعديل بنجاح');
    }

    public function destroy($id)
    {
        $marketer = Marketer::findOrFail($id);
        $marketer->delete();

        return redirect(route('provider.marketers.index'))->with('success', 'تم الحذف  بنجاح');
    }

    public function chargeForm($id = null)
    {
        //$this->authorize(User::class);
        if ($id) {
            $marketer = Marketer::where('id', $id)->first();

            return view('providers.marketers.charge')->with('marketer', $marketer);
        } else {
            return view('providers.marketers.charge');
        }
    }
    public function charge(Request $request)
    {
        $request->validate([
            'marketer_id' => 'numeric|required|exists:marketers,id',
            'amount' => 'numeric|required',
        ]);
        $m = Marketer::where('id', $request->marketer_id)->where('provider_id', auth()->guard('provider')->user()->id)->first();

        $file = null;
        if ($request->hasFile('transfer_img')) {
            $file = $request->file('transfer_img')->store('files', 'public_folder');
        }
        $recharge = Recharge::create([
            // 'code' => $request->code,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'currecny' => $request->currecny,
            'transfer_img' => $file,
            'marketer_id' => $m->id,
        ]);

        if ($recharge->currecny == 'rs') {
            $m->balance_rs = $m->balance_rs + $recharge->amount;
            $m->save();
        } else {
            $m->balance_ry = $m->balance_ry + $recharge->amount;
            $m->save();
        }

        session()->flash('success', 'تم شحن رصيد المسوق بنجاح ');
        return redirect()->route('provider.marketers.index');
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
