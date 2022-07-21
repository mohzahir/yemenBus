<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\Marketer;
use App\Provider;
use App\Reseervation;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\ConfirmReservation;
use App\Mail\PostponeReservation;
use App\Mail\CancelReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Postpone_reservation;
use App\Cancel_reservation;
use App\Http\Requests\ConfirmRequest;
use App\Mail\TransferReservation;
use App\Passenger;
use App\Setting;
use App\Trip;
use App\TripOrderPassenger;
use Session;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ReservationsController extends Controller
{


    public function confirm()
    {
        $marketer = Auth::guard('marketer')->user();
        // dd($marketer);
        $trips = [];
        switch ($marketer->marketer_type) {
            case 'global_marketer':
                $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 1)
                    ->where('no_ticket', '>', 0)
                    ->where('status', 'active')->get();
                break;
            case 'provider_marketer':
                $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 1)
                    ->where('trips.provider_id', $marketer->provider_id)
                    ->where('no_ticket', '>', 0)
                    ->where('status', 'active')->get();
                break;
            case 'service_marketer':
                $providers_ids = Provider::where('service_id', $marketer->service_id)->pluck('id');
                $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 1)
                    ->whereIn('provider_id', $providers_ids)
                    ->where('no_ticket', '>', 0)
                    ->where('status', 'active')
                    ->get();
                break;

            default:
                $trips = [];
                break;
        }
        // dd($trips);
        return view('marketers.reservations.confirm')->with(['trips' => $trips, 'marketer' => $marketer]);
    }




    public function storeConfirm(Request $request)
    {
        $rules = [];
        $seatCount = 0;
        foreach ($request->input('name') as $key => $value) {
            $rules["name.{$key}"] = 'required|string|min:3|max:50';
            $seatCount = $key + 1;
        }
        //return $seatCount;
        $rules['phone'] = 'required|numeric|digits:9'; // for yemen 967-767-890-965 ,sa -> 966-531-066-035 ,
        $rules['email'] = 'nullable|email';
        $rules['notes'] = 'nullable|string|max:1500';

        // $validator = Validator::make($request->all(), $rules);

        // dd($rules);
        $request->validate($rules);

        $phone = $request->input('phoneCountry') == 's' ? '+966' . $request->phone : '+967' . $request->phone;

        // if ($validator->passes()) {

        DB::beginTransaction();

        try {
            $passenger = Passenger::where('email', $request->email)->first();
            if (!$passenger) {
                //passenger is not registered
                $phoneColumnName = $request->input('phoneCountry') == 's' ? 'phone' : 'y_phone';
                $passenger = Passenger::create([
                    'email' => $request->email,
                    'name_passenger' => $request->name[0],
                    $phoneColumnName => $phone
                ]);
            }


            // create reservation 
            $trip = Trip::findOrFail($request->trip_id);

            $marketer = Marketer::findOrFail(auth()->guard('marketer')->user()->id);

            $total = (float)$trip->price * ((int)$seatCount);

            $BUS_RS_DEPOSIT_VALUE = Setting::where('key', 'BUS_RS_DEPOSIT_VALUE')->first()->value;
            $BUS_RY_DEPOSIT_VALUE = Setting::where('key', 'BUS_RY_DEPOSIT_VALUE')->first()->value;

            $deposit = $trip->deposit_price ?? ($trip->currency == 'rs' ? $BUS_RS_DEPOSIT_VALUE : $BUS_RY_DEPOSIT_VALUE);

            $paid = $request->payment_type == 'total_payment' ? $total : $deposit;

            // dd($paid, $marketer->balance_ry, $request->all(), $trip->currency);
            if (($trip->currency == 'rs' && $paid > $marketer->balance_rs) || ($trip->currency == 'ry' && $paid > $marketer->balance_ry)) {
                // return redirect()->back()->withErrors(['error' => 'رصيدك غير كافي لاجراء هذا الحجز الرجاء شحن رصيدك'])->withInput();
                $reservation_id = Reseervation::insertGetId([
                    // 'id' => Str::uuid()->toString(),
                    'trip_id' => $request->trip_id,
                    'marketer_id' => auth()->guard('marketer')->user()->id,
                    'main_passenger_id' => $passenger->id,
                    'ticket_no' =>  '1',
                    'payment_method' =>  null,
                    'payment_time' => null,
                    'payment_type' =>  null,
                    'total_price' =>  $trip->price,
                    'paid' => 0,
                    'ride_place' => $request->ride_place,
                    'drop_place' => $request->drop_place,
                    'currency' => 'rs',
                    // 'note' => $request->notes,
                    'status' => 'created',

                ]);

                return redirect()->route('passengers.tripPayment', ['trip' => $request->trip_id, 'reservation' => $reservation_id])->with(['warning' => ' رصيدك غير كافي لاجراء هذا الحجز الرجاء شحن رصيدك او مواصلة الحجز من خلال الدفع الالكتروني']);
            }

            // var_dump($tripId);exit;

            $reservation = Reseervation::create([
                // 'id' => Str::uuid()->toString(),
                'trip_id' => $request->trip_id,
                'marketer_id' => auth()->guard('marketer')->user()->id,
                'main_passenger_id' => $passenger->id,
                'ticket_no' =>  $seatCount,
                'payment_method' =>  null,
                'payment_time' => date('Y-m-d H:i:s'),
                'payment_type' =>  $request->payment_type,
                'total_price' =>  $total,
                'paid' => $paid,
                'currency' => null,
                'note' => $request->notes,
                'status' => 'confirmed',
                // 's_phone' => $request->phoneCountry == 's' ? '966' . $request->phone : null,
                // 'y_phone' => $request->phoneCountry == 'y' ? '967' . $request->phone : null,
                // 'email' => $request->email,
                // 'price' => $trip->price,
                // 'remain' => $this->calcRemainOfPrice($total),

            ]);

            if ($reservation) {
                $balance_column = $trip->currency == 'rs' ? 'balance_rs' : 'balance_ry';
                $marketer->update([
                    $balance_column => ($marketer[$balance_column] - $paid)
                ]);
            }


            foreach ($request->input('name') as $key => $value) {

                TripOrderPassenger::create([
                    // 'trip_id' => $trip->id,
                    'reservation_id' => $reservation->id,
                    'external_ticket_no' => null,
                    'p_id' => $request->input('nid')[$key],
                    'dateofbirth' => $request->input('dateofbirth')[$key],
                    'age' => $request->input('age')[$key],
                    'gender' => $request->input('gender')[$key],
                    'phone' => $request->input('phone'),
                    'name' => $request->input('name')[$key],
                ]);
            }

            DB::commit(); //966507703877

            // $body = 'حجوزات يمن باص رقم الحجز: ' . $reservation->id . ' يمكنك المتابعه على الرابط التالي :https://www.yemenbus.com/passengers/order/' . $reservation->id;

            // $request->phoneCountry == 's' ? $this->sendSASMS($phone, $body) : $this->sendYESMS($phone, $body);

            return redirect()->route('marketer.reservations.confirmAll')->with(['success' => ' تم اضافه الحجز بنجاح']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        // } else {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
    }


    /* public function test(){
        $this->smsSend(500, 'ser', '+970599342567');
    }*/
    /*
    public function smsSend($amount , $currency,$amount_full,$order_id,$order_url ,$phone){

        $accountId    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $fromNumber  = config('services.twilio.form');
        //require_once "Twilio/autoload.php";
 

        $client = new Client($accountId,$token);
    
            $message = $client->messages->create(
                $phone,
            [
                'from' => $fromNumber, // From a valid Twilio number
                'body' =>    ' '.$order_url.' الرابط : '. $order_id.' الرقم  :'.$amount_full. 'من مبلغ '.$currency.' ريال' .$amount. ' تاكيد حجز بمبلغ '
                ,
            ]
            );
        

    }
*/

    //postpone reservation
    public function postpone($id)
    {

        $reservation = Reseervation::where('id', $id)->first();

        $code = Auth::guard('marketer')->user()->code;



        return view('marketers.reservations.postpone')->with(['reservation' => $reservation, 'code' => $code]);
    }


    public function storePostpone(Request $request)
    {

        $preseervation = Reseervation::where('id', $request->id)->first();
        /*
     $this->authorize('postpone',$preseervation);

        request()->validate([
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
        $preseervation->date = $request->date;
        $preseervation->day = $request->day;

        $preseervation->note = $request->note;
        $preseervation->status = 'postpone';
        $preseervation->save();



        $i = Auth::guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $i)->first();


        $currency = $preseervation->currency == 'sar' ? 'سعودي' : 'يمني';
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new PostponeReservation($preseervation));
        $marketer = Auth::guard('marketer')->user();
        if ($marketer->email) {
            // Send mail to marketer
            $mailToMarketer = $marketer->email;
            Mail::to($mailToMarketer)->send(new PostponeReservation($preseervation));
        }
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

            $provider = Provider::where('id', $preseervation->provider_id)->first();
            if ($provider->phone) {
                $provider_phone = $provider->phone;
                $this->sendSASMS($provider_phone, $body_full);
            }
            if ($provider->y_phone) {
                $provider_phone = $provider->y_phone;

                $this->sendYESMS($provider_phone, $body_full);
            }

            // $this->smsSend($reservation->amount,$currency,$marketer->max_rs,$reservation->order_id,$reservation->order_url,$provider_phone);
            //sendSASMS($provider_phone,$body_full);


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

            $provider = Provider::where('id', $preseervation->provider_id)->first();
            if ($provider->phone) {
                $provider_phone = $provider->phone;
                $this->sendSASMS($provider_phone, $body);
            }
            if ($provider->y_phone) {
                $provider_phone = $provider->y_phone;

                $this->sendYESMS($provider_phone, $body);
            }
        }


        //send sms to passenger phone
        /*    if($preseervation->amount_type =='full'){
                if($request->currency=='sar'){
                    $this->smsPostponeSend($preseervation->amount,$currency,$marketer->max_rs,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
                    // send sms to provider phone
                    $provider_phone = Provider::where('id',$preseervation->provider_id)->first()->phone;
                    $this->smsPostponeSend($preseervation->amount,$currency,$marketer->max_rs,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
        
                }else{
                    $this->smsPostponeSend($preseervation->amount,$currency,$marketer->max_ry,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
                    // send sms to provider phone
                    $provider_phone = Provider::where('id',$preseervation->provider_id)->first()->phone;
                    $this->smsPostponeSend($preseervation->amount,$currency,$marketer->max_ry,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
        

                }

                //send sms to passenger phone
               
                       }else{
                        if($request->currency=='sar'){
            $this->smsPostponeSend($preseervation->amount_deposit,$currency,$marketer->max_rs,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
            // send sms to provider phone
            $provider_phone = Provider::where('id',$preseervation->provider_id)->first()->phone;
            $this->smsPostponeSend($preseervation->amount_deposit,$currency,$marketer->max_rs,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
                        }else{
            $this->smsPostponeSend($preseervation->amount_deposit,$currency,$marketer->max_ry,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
            // send sms to provider phone
            $provider_phone = Provider::where('id',$preseervation->provider_id)->first()->phone;
            $this->smsPostponeSend($preseervation->amount_deposit,$currency,$marketer->max_ry,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
                

                        }
    
        }
    */
        /*  DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }*/

        /*$reservations= Reseervation::where('code',$marketer->code)->paginate('3');
*/
        $date = Carbon::parse($preseervation->date)->format('Y-m-d');
        return response()->json(['url' => route('marketer.reservations.confirmAll'), 'msge' => 'success', 'date' => $date]);
    }

    /*public function smsPostponeSend($amount , $currency,$amount_full,$order_id,$order_url,$phone,$date){

        $accountId    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $fromNumber  = config('services.twilio.form');
        //require_once "Twilio/autoload.php";
 

        $client = new Client($accountId,$token);
    
            $message = $client->messages->create(
                $phone,
            [
                'from' => $fromNumber, // From a valid Twilio number
                'body' =>  $order_url  .' الرابط :' .$date.'الى تاريخ'. $order_id.' الرقم  :'.$amount_full. 'من مبلغ '.$currency.' ريال' .$amount. ' تأجيل حجز بمبلغ '
                ,
            ]
            );
        

    }*/



    public function transfer($id)
    {
        // $reservation = Reseervation::where('id', $id)->first();
        // $marketer = Marketer::where('code', $reservation->code)->first();
        // $code = $marketer->code;
        // $provide_name = $marketer->provide;
        // $provide = Provider::where('name_company', $provide_name)->first();


        // $provide =  $marketer->provide;
        // if ($provide == 'global') {
        //     $companies =  Provider::all();
        // } else {
        //     $comp = $marketer->provide;
        //     $companies =  Provider::where('name_company', $comp)->get();
        // }
        $reservation = Reseervation::findOrFail($id);
        if ($reservation->trip->provider->service_id == 1) {
            //bus
            $marketer = Auth::guard('marketer')->user();
            switch ($marketer->marketer_type) {
                case 'global_marketer':
                    $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                        ->join('providers', 'providers.id', 'trips.provider_id')
                        ->where('providers.service_id', 1)
                        ->where('no_ticket', '>', 0)
                        ->where('status', 'active')->get();
                    break;
                case 'provider_marketer':
                    $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                        ->join('providers', 'providers.id', 'trips.provider_id')
                        ->where('providers.service_id', 1)
                        ->where('trips.provider_id', $marketer->provider_id)
                        ->where('no_ticket', '>', 0)
                        ->where('status', 'active')->get();
                    break;
                case 'service_marketer':
                    $providers_ids = Provider::where('service_id', $marketer->service_id)->pluck('id');
                    $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                        ->join('providers', 'providers.id', 'trips.provider_id')
                        ->where('providers.service_id', 1)
                        ->whereIn('provider_id', $providers_ids)
                        ->where('no_ticket', '>', 0)
                        ->where('status', 'active')
                        ->get();
                    break;

                default:
                    $trips = [];
                    break;
            }
        } else {
            // haj
            $marketer = Auth::guard('marketer')->user();
            switch ($marketer->marketer_type) {
                case 'global_marketer':
                    $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                        ->join('providers', 'providers.id', 'trips.provider_id')
                        ->where('providers.service_id', 3)
                        ->where('no_ticket', '>', 0)
                        ->where('status', 'active')->get();
                    break;
                case 'provider_marketer':
                    $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                        ->join('providers', 'providers.id', 'trips.provider_id')
                        ->where('providers.service_id', 3)
                        ->where('trips.provider_id', $marketer->provider_id)
                        ->where('no_ticket', '>', 0)
                        ->where('status', 'active')->get();
                    break;
                case 'service_marketer':
                    $providers_ids = Provider::where('service_id', $marketer->service_id)->pluck('id');
                    $trips = Trip::query()->select(['*', 'trips.id as trip_id'])
                        ->join('providers', 'providers.id', 'trips.provider_id')
                        ->where('providers.service_id', 3)
                        ->whereIn('provider_id', $providers_ids)
                        ->where('no_ticket', '>', 0)
                        ->where('status', 'active')
                        ->get();
                    break;

                default:
                    $trips = [];
                    break;
            }
        }

        return view('marketers.reservation.transfer', [
            'trips' => $trips,
            'reservation' => $reservation,
        ]);
    }

    public function storetransfer(Request $request)
    {
        // dd($request);
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'reservation_id' => 'required|exists:reseervations,id',
        ]);

        $reservation = Reseervation::findOrFail($request->reservation_id);

        DB::transaction(function () use ($request, $reservation) {
            try {
                $reservation->update([
                    'status' => 'canceled',
                ]);

                $new_reservation = Reseervation::create([
                    'trip_id' => $request->trip_id,
                    'marketer_id' => $reservation->marketer_id,
                    'main_passenger_id' => $reservation->main_passenger_id,
                    'ticket_no' => $reservation->ticket_no,
                    'payment_method' => $reservation->payment_method,
                    'payment_type' => $reservation->payment_type,
                    'payment_time' => date('Y-m-d'),
                    'total_price' => $reservation->total_price,
                    'paid' => $reservation->total_price,
                    'currency' => $reservation->currency,
                    'payment_image' => $reservation->payment_image,
                    'status' => 'confirmed',
                    'note' => $reservation->note,
                    'haj_passenger_external_ticket_number' => $reservation->haj_passenger_external_ticket_number,
                    'haj_passenger_hotel_details' => $reservation->haj_passenger_hotel_details,
                    'haj_passenger_sickness_status' => $reservation->haj_passenger_sickness_status,
                ]);






                //begin send msgs
                // $preseervation = Reseervation::where('id', $request->id)->first();

                $tid = $reservation->trip_id;
                $tday = $reservation->trip->day;
                $tdate = Carbon::parse($reservation->trip->date)->format('m-d');
                $tpr = Provider::where('id', $reservation->trip->provider_id)->first();
                $tprovide = $tpr->name_company;

                $t2tid = $new_reservation->trip->provider_id;
                $t2day = $new_reservation->trip->day;
                $t2pr = Provider::where('id', $t2tid)->first();
                $t2tprovide = $t2pr->name_company;
                $date = Carbon::parse($new_reservation->trip->date)->format('m-d');

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
                switch ($t2day) {
                    case 'sat':
                        $t2day = "السبت";
                        break;
                    case 'sun':
                        $t2day = "الاحد";
                        break;
                    case 'mon':
                        $t2day = "الاثنين";
                        break;
                    case 'tue':
                        $t2day = "الثلاثاء";
                        break;
                    case 'wed':
                        $t2day = "الاربعاء";
                        break;
                    case 'thu':
                        $t2day = "الخميس";
                        break;
                    case 'fri':
                        $t2day = "الجمعة";
                        break;

                    default:
                        break;
                }

                $msgP = 'عزيزي المسافر(' . $new_reservation->passenger->name_passenger . ') تم نقل الحجز رقم (' . $reservation->id . ') من رحله (' . $tid . ') يوم ' . $tday . '/' . $tdate . ' شركة النقل: ' . $tprovide . ' الى رحله(' . $t2tid . ') يوم ' . $t2day . '/' . $date . ' شركة النقل: ' . $t2tprovide;

                $msg = 'تم نقل الحجز رقم (' . $reservation->id . ')من رحله(' . $tid . ') يوم ' . $tday . '/' . $tdate . ' شركة النقل: ' . $tprovide . ' الى رحله ( ' . $t2tid . ' )  يوم ' . $t2day . '/' . $date . ' شركة نقل: ' . $t2tprovide;

                $mailToAdmin = Admin::where('id', 1)->first()->email;
                Mail::to($mailToAdmin)->send(new TransferReservation($msg));
                $marketer = Marketer::where('id', $new_reservation->marketer_id)->first();

                // Send mail to marketer
                if ($marketer->email) {
                    $mailToMarketer = $marketer->email;
                    Mail::to($mailToMarketer)->send(new TransferReservation($msg));
                }
                // $preseervation->date = $request->date;
                // $preseervation->day = $request->day;
                // $preseervation->provider_id = $request->provider_id;
                // $preseervation->trip_id = $request->trip_id;
                // $preseervation->note = $request->note;
                // $preseervation->status = 'transfer';
                // $preseervation->save();



                $provider_phone1 = Provider::where('id', $tpr->id)->first()->phone;
                $provider_phone1_y = Provider::where('id', $tpr->id)->first()->y_phone;
                $provider_phone2_y = Provider::where('id', $new_reservation->trip->provider_id)->first()->y_phone;
                $provider_phone2 = Provider::where('id', $new_reservation->trip->provider_id)->first()->phone;

                if ($new_reservation->passenger->phone) {
                    $this->sendSASMS($new_reservation->passenger->phone, $msgP);
                }
                if ($new_reservation->passenger->y_phone) {
                    $this->sendYESMS($new_reservation->passenger->y_phone, $msgP);
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






                // dd($request);
            } catch (\Throwable $th) {

                throw $th;
            }
        });
        return redirect()->back()->with(['success' => 'تم نقل الحجز بنجاح يمكنك مراجعه الحجوزات']);
    }

    //cancel reservation

    public function cancel($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $idm = Auth::guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $idm)->first();
        $code = $marketer->code;
        return view('marketers.reservations.cancel')->with(['reservation' => $reservation, 'code' => $code]);
    }



    public function storeCancel(Request $request)
    {
        $reservation = Reseervation::where('id', $request->id)->first();
        $currency = $reservation->currency == 'sar' ? 'سعودي' : 'يمني';

        $user = Auth::guard('marketer')->user();
        $this->authorize('cancel', $reservation);
        /*
request()->validate([
            'order_id' => ['required', 'string'],
'passenger_phone'=>['regex:/^(009665|9665|\+9665|05)(5|0|3|6|4|9|1)([0-9]{7})$/i','required_without:passenger_phone_yem','nullable'],

'passenger_phone_yem'=>['regex:/^(00967|967|\+967)([0-9]{9})$/i','required_without:passenger_phone','nullable'],
           

        ], [
            'order_id.required' => 'رقم الطلب إجباري',
            'passenger_phone.regex'=>'الرقم غير صحيح',
'passenger_phone.required_without'=>'يجب ادخال احد الرقمين',
'passenger_phone_yem.regex'=>'الرقم غير صحيح',
'passenger_phone_yem.required_without'=>'يجب ادخال احد الرقمين',

        ]);*/


        // DB::beginTransaction();
        // try {
        //save to db table reseervations 

        $reservation->status = 'cancel';
        $reservation->save();


        $provider_phone = Provider::where('id', $reservation->provider_id)->first();

        $currency = $reservation->currency == 'sar' ? 'سعودي' : 'يمني';
        $i = Auth::guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $i)->first();
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new CancelReservation($reservation));
        $marketer = Auth::guard('marketer')->user();
        if ($marketer->email) {
            //Send mail to marketer
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
            //send sms to passenger phone
            // send sms to provider phone
            if ($reservation->passenger_phone) {
                $to = $reservation->passenger_phone;
                $this->sendSASMS($to, $body_full);
            }
            if ($reservation->passenger_phone_yem) {
                $to = $reservation->passenger_phone_yem;
                $this->sendYESMS($to, $body_full);
            }
            $provider = Provider::where('id', $reservation->provider_id)->first();
            if ($provider->phone) {
                $provider_phone = $provider->phone;

                $this->sendSASMS($provider_phone, $body_full);
            }
            if ($provider->y_phone) {
                $provider_phone = $provider->y_phone;
                $this->sendYESMS($provider_phone, $body_full);
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


            //send sms to passenger phone
            // send sms to provider phone
            if ($reservation->passenger_phone) {
                $to = $reservation->passenger_phone;
                $this->sendSASMS($to, $body);
            }
            if ($reservation->passenger_phone_yem) {
                $to = $reservation->passenger_phone_yem;
                $this->sendYESMS($to, $body);
            }
            $provider = Provider::where('id', $reservation->provider_id)->first();
            if ($provider->phone) {
                $provider_phone = $provider->phone;

                $this->sendSASMS($provider_phone, $body);
            }
            if ($provider->y_phone) {
                $provider_phone = $provider->y_phone;
                $this->sendYESMS($provider_phone, $body);
            }
        }

        /*  DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }*/


        return response()->json(['url' => route('marketer.reservations.confirmAll'), 'msge' => 'success']);
    }

    public function downloadImage($id)
    {
        $reservation = Reseervation::where('id', $id)->firstOrFail();
        $path = public_path() . '/images/reservation/' . $reservation->image;
        return response()->download($path, $reservation
            ->original_filename, ['Content-Type' => $reservation->mime]);
    }

    /*
    public function smsCancelSend($amount, $currency,$amount_full,$order_id,$order_url,$phone){

        $accountId    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $fromNumber  = config('services.twilio.form');
        //require_once "Twilio/autoload.php";
 

        $client = new Client($accountId,$token);
    
            $message = $client->messages->create(
                $phone,
            [
                'from' => $fromNumber, // From a valid Twilio number
                'body' =>  $order_url  .' الرابط :' . $order_id.' الرقم  :'.$amount_full. 'من مبلغ '.$currency.' ريال' .$amount. ' الغاء حجز بمبلغ '
                ,
            ]
            );
        

    }*/



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
        $idm = Auth::guard('marketer')->user()->id;
        $marketer = Marketer::where('id', $idm)->first();
        $code = $marketer->code;
        return view('marketers.reservations.update')->with(['reservation' => $reservation, 'code' => $code]);
    }
    public function Update(Request $request, $id)
    {

        $preseervation = Reseervation::where('id', $request->id)->first();
        $this->authorize('update', $preseervation);

        $preseervation->order_id = $request->order_id;
        $preseervation->demand_id = $request->demand_id;

        $preseervation->order_url = $request->order_url;
        $preseervation->ticket_no = $request->ticket_no;

        if ($request->hasFile('image')) {
            if ($preseervation->image) {
                $image_path = public_path() . '/images/reservation/' . $preseervation->image;
                unlink($image_path);
            }
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            $input['image'] = $imageName;
            request()->image->move(public_path('/images/reservation/'), $imageName);

            $preseervation->image = $imageName;
        }
        $preseervation->save();


        return response()->json(['url' => route('marketer.reservations.confirmAll'), 'msge' => 'success']);
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
