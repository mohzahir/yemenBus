<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reseervation;
use App\Marketer;
use App\Address;
use App\Admin;
use App\Provider;
use App\Sms;
use App\Cancel_reservation;
use App\Http\Requests\SmsRequest;

use Auth;
use Twilio\Rest\Client;
use Illuminate\Validation\Rule;
use App\Mail\SmsSend;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Jawaly;
use App\helpers;
use App\Trip;
use App\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;


class MarketersController extends Controller
{


    public function info()
    {
        return view('marketers.info');
    }
    public function services()
    {
        return view('marketers.services');
    }
    public function archive()
    {
        $code = Auth::guard('marketer')->user()->code;
        //$markeetr=Marketer::where('code',$code)->first();

        $postpone = Reseervation::where(['code' => $code, 'status' => 'postpone'])->count();
        $confirm = Reseervation::where(['code' => $code, 'status' => 'confirm'])->count();
        $cancel = Cancel_reservation::where('code', $code)->count();
        $full_amount = Reseervation::where(['code' => $code, ['amount', '=', 'amount_deposit']])->count();
        $deposit_amount = Reseervation::where(['code' => $code, ['amount', '<>', 'amount_deposit']])->count();

        return view('marketers.archive')->with(['postpone' => $postpone, 'confirm' => $confirm, 'cancel' => $cancel, 'full_amount' => $full_amount, 'deposit_amount' => $deposit_amount]);
    }
    public function charge()
    {
        //return view('marketers.charge');
    }
    public function showAccountInfo()
    {
        $id = auth()->guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $id)->first();
        $address = Address::where('user_id', $id)->first();
        return view('marketers.info')->with(['marketer' => $marketer, 'address' => $address]);
    }

    public function updateAccountInfoForm()
    {

        $id =  auth()->guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $id)->first();

        return view('marketers.settings')->with('marketer', $marketer);
    }

    public function UpdateAccountInfo(Request $request)
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

        $id = auth()->guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $id)->first();
        if ($request['password']) {
            $marketer->password = Hash::make($request['password']);
        }
        $marketer->update([
            'name' => $request['name'],
            'email' => $request['email'],
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






        if ($request->phone) {
            $marketer->phone = $phone;
        } else {
            $marketer->y_phone = $phoneProv;
        }

        $marketer->save();

        return view('marketers.info')->with('marketer', $marketer);
    }

    public function confirm()
    {
        $marketer = Auth::guard('marketer')->user();
        // dd($id);
        $reservations = [];
        switch ($marketer->marketer_type) {
            case 'global_marketer':
                $reservations = Reseervation::query()
                    ->join('trips', 'trips.id', 'reseervations.trip_id')
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 1)
                    ->where('reseervations.status', '!=', 'canceled')
                    ->paginate(10);
                break;
            case 'provider_marketer':
                $reservations = Reseervation::query()
                    ->join('trips', 'trips.id', 'reseervations.trip_id')
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 1)
                    ->where('trips.provider_id', $marketer->provider_id)
                    ->where('reseervations.status', '!=', 'canceled')
                    ->paginate(10);
                break;
            case 'service_marketer':
                $providers_ids = Provider::where('service_id', $marketer->service_id)->pluck('id');
                $reservations = Reseervation::query()
                    ->join('trips', 'trips.id', 'reseervations.trip_id')
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 1)
                    ->whereIn('trips.provider_id', $providers_ids)
                    ->where('reseervations.status', '!=', 'canceled')
                    ->paginate(10);
                break;

            default:
                $reservations = [];
                break;
        }
        // $reservations = Reseervation::where('marketer_id', $id)->orderby('id', 'desc')->paginate('10');

        return view('marketers.reservation.conform')->with('reservations', $reservations);
    }

    public function sms($id = null)
    {
        if ($id) {
            $reservation = Reseervation::where('id', $id)->first();
            return view('marketers.sms')->with(['reservation' => $reservation]);
        }
        $reservation = null;
        return view('marketers.sms')->with(['reservation' => $reservation]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSms(SmsRequest $request)
    {
        request()->validate([
            'message' => ['required']

        ], [

            'message.required' => ' يرجى ادخال  محتوى الرساله ',
        ]);



        $body = $request->message;


        if ($request->passenger_phone) {
            $to = $request->passenger_phone;
            $this->sendSASMS($to, $body);
        } else {
            $to = $request->passenger_phone_yem;
            $this->sendYESMS($to, $body);
        }


        /*
        $accountId    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $fromNumber  = config('services.twilio.form');


        $client = new Client($accountId,$token);
    
            $message = $client->messages->create(
                $phone,
            [
                'from' => $fromNumber, // From a valid Twilio number
                'body' =>$request->message,
            ]
            );
            */
        $data = $request->all();

        //Sms::create($data);
        $em = $to . 'تم ارسال رساله بنجاح  الى مسافر صاحب الرقم ';

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new SmsSend($em));
        $m = Auth::guard('marketer')->user();
        if ($m->email) {
            $mailToMarketer = $m->email;
            Mail::to($mailToMarketer)->send(new SmsSend($em));
        }

        return back()->with('success', 'تم ارسال رسال الى العميل ');
    }
    public function trips()
    {
        $id = Auth::guard('marketer')->user()->id;
        $marketer = Marketer::findOrFail($id);
        $trips = Trip::where('provider_id', $marketer->provider_id)->orderby('created_at', 'desc')->paginate(10);
        return view('marketers.trip.index')->with('trips', $trips);
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
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $code = Auth::guard('marketer')->user()->code;
            $output = "";
            $reseervations = DB::table('reseervations')
                ->where('order_id', 'LIKE', '%' . $request->search . "%")
                ->where('code', $code)
                ->get();
            if ($reseervations) {


                foreach ($reseervations as $key => $reseervation) {
                    if ($reseervation->amount_type == 'full') {
                        $type = "كامل  المبلغ";
                    } else {
                        $type = "بعربون";
                    }
                    $day = "";
                    switch ($reseervation->day) {
                        case 'sat':
                            $day = "السبت";
                            break;
                        case 'sun':
                            $day = "الاحد";
                            break;
                        case 'mon':
                            $day = " الاتنين";
                            break;
                        case 'tue':
                            $day = "الثلاثاء";
                            break;
                        case 'wed':
                            $day = "الاربعاء";
                            break;
                        case 'thu':
                            $day = "الخميس";
                            break;
                        case 'fri':
                            $day = "الجمعة";
                            break;

                        default:
                            $day = "";
                            break;
                    }

                    $provider = Provider::where('id', $reseervation->provider_id)->first();
                    $output .= '<tr>' .
                        '<td>' . $reseervation->order_id . '</td>' .
                        '<td>                            </td>' .
                        '<td>' . $reseervation->order_url . '</td>' .
                        '<td>' . $reseervation->passenger_phone . '</td>' .
                        '<td>' . $reseervation->passenger_phone_yem . '</td>' .
                        '<td>' . $reseervation->whatsup . '</td>' .

                        '<td>' . $provider->name_company . '</td>' .

                        '<td>' . $reseervation->amount . '</td>' .
                        '<td>' . $reseervation->amount_deposit . '</td>' .
                        '<td>' . $type . '</td>' .
                        '<td>' . $day . '</td>' .
                        '<td>' . $reseervation->date . '</td>' .

                        '<td style="display:inline;width:100%"><a class="btn btn-sm btn-warning" href="postpone/' . $reseervation->id . '" style="margin-bottom: 10px">تأجيل الحجز</a>
                    <a class="btn btn-sm btn-danger" href="cancel/' . $reseervation->id . '">الغاء الحجز</a>
                    </td>' .

                        '<td style="width:150px;margin-top:30px">
                    <a class="btn btn-sm btn-primary" href="sms/' . $reseervation->id . '" style="margin-bottom: 10px"> <span class="glyphicon glyphicon-envelope"></span>   راسل المسافر   </a>
                    <a class="btn btn-sm btn-success" href="https://api.whatsapp.com/send?phone=' .
                        $reseervation->passenger_phone . '" style="width:100px">واتس اب </a>

                    
                    </td>' .
                        '</tr>';
                }
                return Response($output);
            }
        }
    }
}
