<?php

namespace App\Http\Controllers\admin;

use App\Sms;
use App\User;
use App\Admin;
use App\helpers;
use App\Marketer;
use App\Provider;
use Carbon\Carbon;
use App\Mail\SmsSend;
use App\Reseervation;
use Twilio\Rest\Client;
use App\Cancel_reservation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Postpone_reservation;
use App\Mail\CancelReservation;
use Illuminate\Validation\Rule;

use App\Mail\ConfirmReservation;
use App\Http\Requests\SmsRequest;
use App\Mail\PostponeReservation;
use App\Mail\TransferReservation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Trip;
use App\TripOrderPassenger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Jawaly;



class AdminReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm()
    {
        // $reservations=Reseervation::orderby('created_at', 'desc')->paginate('10');
        // $reservations = Reseervation::getFullReservationsDetails();
        $trips = Trip::query()
            ->join('providers', 'providers.id', 'trips.provider_id')
            ->where('providers.service_id', '1')
            ->pluck('trips.id');
        $reservations = Reseervation::whereIn('trip_id', $trips)->paginate('10');

        // dd($reservations);
        return view('dashboard.reservation.conform')->with('reservations', $reservations);
    }


    public function passengersList($id)
    {
        $passengers = TripOrderPassenger::where('reservation_id', $id)->get();
        // dd($reservation);
        return view('dashboard.reservation.passengersList')->with(['passengers' => $passengers]);
    }

    public function savePassengersTickets(Request $request)
    {
        foreach ($request->external_ticket_no as $key => $item) {
            // dd($request->id[$key]);
            TripOrderPassenger::where('id', $request->id[$key])->update([
                'external_ticket_no' => $item
            ]);
        }

        return redirect()->back()->with(['info' => 'تم حفظ ارقام التزاكر']);
    }

    //postpone reservation
    public function postpone($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $marketer = Marketer::where('code', $reservation->code)->first();
        $code = $marketer->code;


        return view('dashboard.reservation.postpone')->with(['reservation' => $reservation, 'code' => $marketer->code]);
    }


    public function storePostpone(Request $request)
    {
        /* request()->validate([
            'order_id' => ['required', 'string'],
'passenger_phone'=>['regex:/^(009665|9665|\+9665|05)(5|0|3|6|4|9|1)([0-9]{7})$/i','required_without:passenger_phone_yem','nullable'],

'passenger_phone_yem'=>['regex:/^(00967|967|\+967)([0-9]{9})$/i','required_without:passenger_phone','nullable'],
            'currency' => ['required', 'string', Rule::in(['sar','yer'])], 
            'amount' => ['required', 'string'],
            'date'=>['required']

        ], [
            'order_id.required' => 'رقم الطلب إجباري',
            'currency.required' => 'اختيار العملة إجباري',
            'amount.required' => ' المبلغ إجباري',
            'date.required' => ' يرجى ادخال تاريخ التاجيل ',
            'passenger_phone.regex'=>'الرقم غير صحيح',
'passenger_phone.required_without'=>'يجب ادخال احد الرقمين',
'passenger_phone_yem.regex'=>'الرقم غير صحيح',
'passenger_phone_yem.required_without'=>'يجب ادخال احد الرقمين',

        ]);*/
        $data = $request->all();
        $preseervation = Reseervation::where('id', $request->id)->first();
        $preseervation->day = $request->day;

        $preseervation->date = $request->date;
        $preseervation->note = $request->note;
        $preseervation->status = 'postpone';
        $preseervation->save();



        $marketer = Marketer::where('code', $preseervation->code)->first();



        $currency = $preseervation->currency == 'sar' ? 'سعودي' : 'يمني';
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new PostponeReservation($preseervation));
        if ($marketer->email) {
            // Send mail to marketer
            $mailToMarketer = $marketer->email;
            Mail::to($mailToMarketer)->send(new PostponeReservation($preseervation));
        }
        //send sms to passenger phone
        if ($preseervation->amount_type == 'full') {
            $provider = Provider::where('id', $preseervation->provider_id)->first();
            $provider_name = $provider->name_company;
            $date = Carbon::parse($preseervation->date)->format('m-d');
            $day = $preseervation->day;
            switch ($day) {
                case 'sat':
                    $day = "السبت";
                    break;
                case 'sun':
                    $day = "الاحد";
                    break;
                case 'mon':
                    $day = "الاثنين";
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
                    break;
            }


            $body_full = 'عزيزي المسافر(' . $preseervation->passenger_name . ')تم تأجيل حجز بمبلغ(' . $preseervation->amount . ')من مبلغ(' . $preseervation->amount . ')ريال ' . $currency . ' رقم الحجز(' . $preseervation->id . ')/' . $provider_name . '/' . $preseervation->from_city . '/' . $preseervation->to_city . '/' . $day . '/' . $date . ' عدد التذاكر(' . $preseervation->ticket_no . ')';

            //send sms to passenger phone
            // send sms to provider phone
            if ($preseervation->passenger_phone) {
                $to = $preseervation->passenger_phone;
                $this->sendSASMS($to, $body_full);
            }
            if ($preseervation->passenger_phone_yem) {
                $to = $preseervation->passenger_phone_yem;
                $this->sendYESMS($to, $body_full);
            }
            $provider_phone = Provider::where('id', $preseervation->provider_id)->first()->phone;
            $provider_phone_y = Provider::where('id', $preseervation->provider_id)->first()->y_phone;
            if ($provider_phone) {
                $this->sendSASMS($provider_phone, $body_full);
            }
            if ($provider_phone_y) {
                $this->sendYESMS($provider_phone_y, $body_full);
            }
        } else {
            $provider = Provider::where('id', $preseervation->provider_id)->first();
            $provider_name = $provider->name_company;
            $date = Carbon::parse($preseervation->date)->format('m-d');
            $day = $preseervation->day;
            switch ($day) {
                case 'sat':
                    $day = "السبت";
                    break;
                case 'sun':
                    $day = "الاحد";
                    break;
                case 'mon':
                    $day = "الاثنين";
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
                    break;
            }


            $body = 'عزيزي المسافر(' . $preseervation->passenger_name . ')تم تأجيل حجز بمبلغ(' . $preseervation->amount_deposit . ')من مبلغ(' . $preseervation->amount . ')ريال ' . $currency . ' رقم الحجز(' . $preseervation->id . ')/' . $provider_name . '/' . $preseervation->from_city . '/' . $preseervation->to_city . '/' . $day . '/' . $date . ' عدد التذاكر(' . $preseervation->ticket_no . ')';

            if ($preseervation->passenger_phone) {
                $to = $preseervation->passenger_phone;
                $this->sendSASMS($to, $body);
            }
            if ($preseervation->passenger_phone_yem) {
                $to = $preseervation->passenger_phone_yem;
                $this->sendYESMS($to, $body);
            }
            $provider_phone = Provider::where('id', $preseervation->provider_id)->first()->phone;
            $provider_phone_y = Provider::where('id', $preseervation->provider_id)->first()->y_phone;
            if ($provider_phone) {
                $this->sendSASMS($provider_phone, $body);
            }
            if ($provider_phone_y) {
                $this->sendYESMS($provider_phone_y, $body);
            }
        }

        $date = Carbon::parse($preseervation->date)->format('Y-m-d');
        return response()->json(['url' => route('admin.reservations.confirmAll'), 'msge' => 'success']);
    }

    /* public function smsPostponeSend($amount , $currency,$amount_full,$order_id,$order_url,$phone,$date){

        $accountId    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $fromNumber  = config('services.twilio.form');
        //require_once "Twilio/autoload.php";
 

        $client = new Client($accountId, $token);
    
            $message = $client->messages->create(
                $phone,
            [
                'from' => $fromNumber, // From a valid Twilio number
                'body' =>  $order_url  .' الرابط :' .$date.'الى تاريخ'. $order_id.' الرقم  :'.$amount_full. 'من مبلغ '.$currency.' ريال' .$amount. ' تأجيل حجز بمبلغ '
                ,
            ]
            );
        

    }*/

    //cancel reservation

    public function cancel($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $reservation->update(['status' => 'canceled']);
        if ($reservation->marketer_id) {
            $column = $reservation->trip->currency == 'rs' ? 'balance_rs' : 'balance_ry';
            $reservation->marketer->update([
                $column => $reservation->marketer[$column] + $reservation->paid,
            ]);
        }
        return redirect()->back()->with(['message' => 'تم الغاء الطلب بنجاح']);

        // $marketer = Marketer::where('id', $reservation->marketer_id)->first();
        // $code = null;
        // $marketer ? $code = $marketer->code : $code = null;

        // return view('providers.reservation.cancel')->with(['reservation' => $reservation, 'code' => $code]);
    }



    public function storeCancel(Request $request)

    {
        $data = $request->all();

        // DB::beginTransaction();
        // try {
        //save to db table reseervations 


        $reservation = Reseervation::where('id', $request->id)->first();

        $reservation->status = 'cancel';
        $reservation->save();

        $provider_phone = Provider::where('id', $reservation->provider_id)->first();

        $currency = $reservation->currency == 'sar' ? 'سعودي' : 'يمني';
        $marketer = Marketer::where('code', $reservation->code)->first();
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new CancelReservation($reservation));

        // Send mail to marketer
        if ($marketer->email) {
            $mailToMarketer = $marketer->email;
            Mail::to($mailToMarketer)->send(new CancelReservation($reservation));
        }
        //send sms to passenger phone
        if ($reservation->amount_type == 'full') {
            $provider = Provider::where('id', $reservation->provider_id)->first();
            $provider_name = $provider->name_company;
            $date = Carbon::parse($reservation->date)->format('m-d');
            $day = $reservation->day;
            switch ($day) {
                case 'sat':
                    $day = "السبت";
                    break;
                case 'sun':
                    $day = "الاحد";
                    break;
                case 'mon':
                    $day = "الاثنين";
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
                    break;
            }

            $body_full = 'عزيزي المسافر(' . $reservation->passenger_name . ')تم الغاء حجز بمبلغ(' . $reservation->amount . ')من مبلغ(' . $reservation->amount . ')ريال ' . $currency . ' رقم الحجز(' . $reservation->id . ')/' . $provider_name . '/' . $reservation->from_city . '/' . $reservation->to_city . '/' . $day . '/' . $date . ' عدد التذاكر(' . $reservation->ticket_no . ')';

            if ($reservation->passenger_phone) {
                $to = $reservation->passenger_phone;
                $this->sendSASMS($to, $body_full);
            }
            if ($reservation->passenger_phone_yem) {
                $to = $reservation->passenger_phone_yem;
                $this->sendYESMS($to, $body_full);
            }
            $provider_phone = Provider::where('id', $reservation->provider_id)->first()->phone;
            $provider_phone_y = Provider::where('id', $reservation->provider_id)->first()->y_phone;
            if ($provider_phone) {
                $this->sendSASMS($provider_phone, $body_full);
            }
            if ($provider_phone_y) {
                $this->sendYESMS($provider_phone_y, $body_full);
            }
        } else {
            $provider = Provider::where('id', $reservation->provider_id)->first();
            $provider_name = $provider->name_company;
            $date = Carbon::parse($reservation->date)->format('m-d');
            $day = $reservation->day;
            switch ($day) {
                case 'sat':
                    $day = "السبت";
                    break;
                case 'sun':
                    $day = "الاحد";
                    break;
                case 'mon':
                    $day = "الاثنين";
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
                    break;
            }
            $body = 'عزيزي المسافر(' . $reservation->passenger_name . ')تم الغاء حجز بمبلغ(' . $reservation->amount_deposit . ')من مبلغ(' . $reservation->amount . ')ريال ' . $currency . ' رقم الحجز(' . $reservation->id . ')/' . $provider_name . '/' . $reservation->from_city . '/' . $reservation->to_city . '/' . $day . '/' . $date . ' عدد التذاكر(' . $reservation->ticket_no . ')';
            if ($reservation->passenger_phone) {
                $to = $reservation->passenger_phone;
                $this->sendSASMS($to, $body);
            }
            if ($reservation->passenger_phone_yem) {
                $to = $reservation->passenger_phone_yem;
                $this->sendYESMS($to, $body);
            }
            $provider_phone = Provider::where('id', $reservation->provider_id)->first()->phone;
            $provider_phone_y = Provider::where('id', $reservation->provider_id)->first()->y_phone;
            if ($provider_phone) {
                $this->sendSASMS($provider_phone, $body);
            }
            if ($provider_phone_y) {
                $this->sendYESMS($provider_phone_y, $body);
            }
        }
        return response()->json(['url' => route('admin.reservations.confirmAll'), 'msge' => 'success']);
    }




    //postpone reservation
    public function transfer($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $marketer = Marketer::where('code', $reservation->code)->first();
        $code = $marketer->code;
        $provide_name = $marketer->provide;
        $provide = Provider::where('name_company', $provide_name)->first();


        $provide =  $marketer->provide;
        if ($provide == 'global') {
            $companies =  Provider::all();
        } else {
            $comp = $marketer->provide;
            $companies =  Provider::where('name_company', $comp)->get();
        }


        return view('dashboard.reservation.transfer')->with(['reservation' => $reservation, 'code' => $code, 'companies' => $companies]);
    }


    public function storeTransfer(Request $request)
    {
        /*request()->validate([
        'order_id' => ['required', 'string'],
'passenger_phone'=>['regex:/^(009665|9665|\+9665|05)(5|0|3|6|4|9|1)([0-9]{7})$/i','required_without:passenger_phone_yem','nullable'],

'passenger_phone_yem'=>['regex:/^(00967|967|\+967)([0-9]{9})$/i','required_without:passenger_phone','nullable'],
             'currency' => ['required', 'string', Rule::in(['sar','yer'])], 
        'amount' => ['required', 'string'],
        'date'=>['required']

    ], [
        'order_id.required' => 'رقم الطلب إجباري',
 'passenger_phone.regex'=>'الرقم غير صحيح',
'passenger_phone.required_without'=>'يجب ادخال احد الرقمين',
'passenger_phone_yem.regex'=>'الرقم غير صحيح',
'passenger_phone_yem.required_without'=>'يجب ادخال احد الرقمين',
        'currency.required' => 'اختيار العملة إجباري',
        'amount.required' => ' المبلغ إجباري',
        'date.required' => ' يرجى ادخال تاريخ التاجيل ',
    ]);*/
        $data = $request->all();
        $preseervation = Reseervation::where('id', $request->id)->first();

        $tid = $preseervation->trip_id;
        $tday = $preseervation->day;
        $tdate = Carbon::parse($preseervation->date)->format('m-d');
        $tpr = Provider::where('id', $preseervation->provider_id)->first();
        $tprovide = $tpr->name_company;

        $t2tid = $request->provider_id;
        $t2pr = Provider::where('id', $t2tid)->first();
        $t2tprovide = $t2pr->name_company;
        $date = Carbon::parse($request->date)->format('m-d');

        switch ($tday) {
            case 'sat':
                $tday = "السبت";
                break;
            case 'sun':
                $tday = "الاحد";
                break;
            case 'mon':
                $tday = "الاثنين";
                break;
            case 'tue':
                $tday = "الثلاثاء";
                break;
            case 'wed':
                $tday = "الاربعاء";
                break;
            case 'thu':
                $tday = "الخميس";
                break;
            case 'fri':
                $tday = "الجمعة";
                break;

            default:
                break;
        }
        $day = $request->day;
        switch ($day) {
            case 'sat':
                $day = "السبت";
                break;
            case 'sun':
                $day = "الاحد";
                break;
            case 'mon':
                $day = "الاثنين";
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
                break;
        }

        $msgP = 'عزيزي المسافر(' . $preseervation->passenger_name . ') تم نقل الحجز رقم (' . $request->id . ') من رحله (' . $tid . ') يوم ' . $tday . '/' . $tdate . ' شركة النقل: ' . $tprovide . ' الى رحله(' . $request->trip_id . ') يوم ' . $day . '/' . $date . ' شركة النقل: ' . $t2tprovide;

        $msg = 'تم نقل الحجز رقم (' . $request->id . ')من رحله(' . $tid . ') يوم ' . $tday . '/' . $tdate . ' شركة النقل: ' . $tprovide . ' الى رحله ( ' . $request->trip_id . ' )  يوم ' . $day . '/' . $date . ' شركة نقل: ' . $t2tprovide;

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new TransferReservation($msg));
        $marketer = Marketer::where('code', $preseervation->code)->first();

        // Send mail to marketer
        if ($marketer->email) {
            $mailToMarketer = $marketer->email;
            Mail::to($mailToMarketer)->send(new TransferReservation($msg));
        }
        $preseervation->date = $request->date;
        $preseervation->day = $request->day;
        $preseervation->provider_id = $request->provider_id;
        $preseervation->trip_id = $request->trip_id;
        $preseervation->note = $request->note;
        $preseervation->status = 'transfer';
        $preseervation->save();



        $provider_phone1 = Provider::where('id', $tpr->id)->first()->phone;
        $provider_phone1_y = Provider::where('id', $tpr->id)->first()->y_phone;
        $provider_phone2_y = Provider::where('id', $preseervation->provider_id)->first()->y_phone;
        $provider_phone2 = Provider::where('id', $preseervation->provider_id)->first()->phone;

        if ($preseervation->passenger_phone) {
            $this->$this->sendSASMS($preseervation->passenger_phone, $msgP);
        }
        if ($preseervation->passenger_phone_yem) {
            $this->sendYESMS($preseervation->passenger_phone_yem, $msgP);
        }


        if ($provider_phone2) {
            $this->sendSASMS($provider_phone2, $msg);
        }
        if ($provider_phone1) {
            $this->sendSASMS($provider_phone1, $msg);
        }
        if ($provider_phone2_y) {
            $this->sendYESMS($provider_phone2_y, $msg);
        }
        if ($provider_phone1_y) {
            $this->sendYESMS($provider_phone1_y, $msg);
        }





        // Send mail to admin


        //send sms to passenger phone





        /*  DB::commit();

    } catch (Throwable $e) {
        DB::rollBack();
        throw $e;
    }*/
        return response()->json(['url' => route('admin.reservations.confirmAll'), 'msge' => 'success']);
    }


    public function sms($id = null)
    {
        if ($id) {
            $reservation = Reseervation::where('id', $id)->first();
            return view('dashboard.sms')->with(['reservation' => $reservation]);
        }
        $reservation = null;
        return view('dashboard.sms')->with(['reservation' => $reservation]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSms(SmsRequest $request)
    {

        $provider = Provider::where('id', $request->provider_id)->first();

        $passenger_phone = "";
        if ($request->passenger_phone) {
            $into = Str::substr($request->passenger_phone, 0, 2);

            if ($into == '05') {
                $phoneP = Str::substr($request->passenger_phone, 2, 8);

                $passenger_phone = "9665" . $phoneP;
            } else {
                $passenger_phone = $request->passenger_phone;
            }
        }

        $passenger_phone_yem = "";
        if ($request->passenger_phone_yem) {
            $into = Str::substr($request->passenger_phone_yem, 0, 1);

            if ($into == '7') {
                $phonef = Str::substr($request->passenger_phone_yem, 1, 8);

                $passenger_phone_yem = "9677" . $phonef;
            } else {
                $passenger_phone_yem = $request->passenger_phone_yem;
            }
        }


        $body = $request->message;
        if ($request->passenger_phone) {
            $to = $passenger_phone;
            $this->sendSASMS($to, $body);
        }
        if ($passenger_phone_yem) {
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

        // Sms::create($data);
        $em = $to . 'تم ارسال رساله بنجاح  الى مسافر صاحب الرقم ';

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new SmsSend($em));



        return redirect()
            ->route('admin.reservations.confirmAll')->with('success', 'تم ارسال رسال الى العميل ');
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
    public function date(Request $request)
    {
        $carbon = new Carbon($request->date);
        $day = $carbon->format('l');


        switch ($day) {
            case 'Saturday':
                $d = "sat";
                break;
            case 'Sunday':
                $d = "sun";
                break;
            case 'Monday':
                $d = "mon";
                break;
            case 'Tuesday':
                $d = "tue";
                break;
            case 'Wednesday':
                $d = "wed";
                break;
            case 'Thursday':
                $d = "thu";
                break;
            case 'Friday':
                $d = "fri";
                break;

            default:
                $d = "الك";
                break;
        }

        return $d;
    }

    public function edit($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $bus_trips = Trip::query()
            ->join('providers', 'providers.id', 'trips.provider_id')
            ->where('providers.service_id', 1)
            ->where('trips.status', 'active')
            ->get();
        $marketers = Marketer::get();

        return view('dashboard.reservation.update')->with([
            'reservation' => $reservation,
            'bus_trips' => $bus_trips,
            'marketers' => $marketers,
        ]);
    }
    public function Update(Request $request, $id)
    {
        $request->validate([
            'trip_id' => 'required|numeric|exists:trips,id',
            'marketer_id' => 'nullable|numeric',
            'ride_place' => 'nullable',
            'drop_place' => 'nullable',
            'note' => 'nullable',
        ]);

        $preseervation = Reseervation::findOrFail($id);
        $preseervation->trip_id = $request->trip_id;
        $preseervation->marketer_id = $request->marketer_id;

        $preseervation->ride_place = $request->ride_place;
        $preseervation->drop_place = $request->drop_place;
        $preseervation->note = $request->note;

        $preseervation->save();


        return redirect()->route('admin.reservations.confirmAll')->with(['success' => 'تم تعديل بيانات الحجز بنجاح']);
    }
    public function downloadImage($id)
    {
        $reservation = Reseervation::where('id', $id)->firstOrFail();
        $path = public_path() . '/images/reservation/' . $reservation->image;
        return response()->download($path, $reservation
            ->original_filename, ['Content-Type' => $reservation->mime]);
    }
}
