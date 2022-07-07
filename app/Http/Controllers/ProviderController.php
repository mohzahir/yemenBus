<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Provider;
use App\Address;
use App\Bank;
use App\Reseervation;
use App\Http\Requests\SmsRequest;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Marketer;
use App\Admin;
use Twilio\Rest\Client;
use Illuminate\Validation\Rule;
use App\Mail\ConfirmReservation;
use App\Mail\PostponeReservation;
use App\Mail\CancelReservation;
use App\Mail\TransferReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Postpone_reservation;
use App\Cancel_reservation;
use Hash;
use App\Sms;
use App\Mail\SmsSend;
use Illuminate\Support\Facades\Jawaly;
use App\helpers;
use App\Trip;
use App\TripOrderPassenger;
use Response;
use Validator;
use Illuminate\Support\Str;


class ProviderController extends Controller
{
    public function showAccountInfo()
    {
        $id =  auth()->guard('provider')->user()->id;
        // dd(auth()->guard('provider')->user());
        $provider = Provider::where('id', $id)->first();
        $address = Address::where('user_id', $id)->first();
        $bank = Bank::where('provider_id', $id)->first();
        return view('providers.account_information')->with(['provider' => $provider, 'address' => $address, 'bank' => $bank]);
    }

    public function updateAccountInfoForm()
    {

        $id =  auth()->guard('provider')->user()->id;
        $provider = Provider::where('id', $id)->first();


        $address = Address::where('user_id', $id)->first();
        $bank = Bank::where('provider_id', $id)->first();
        return view('providers.settting_account')->with(['provider' => $provider, 'address' => $address, 'bank' => $bank]);
    }

    public function UpdateAccountInfo(Request $request)
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

        $id = auth()->guard('provider')->user()->id;
        $provider = Provider::where('id', $id)->first();

        if ($request['password']) {
            $provider->password = Hash::make($request['password']);
        }
        $provider->update([
            'email' => $request['email'],
            'name_company' => $request['name_company'],
            'city' => $request['city'],
        ]);
        if ($request->phone) {
            $provider->phone = $phone;
        } else {
            $provider->y_phone = $phoneProv;
        }

        if ($request->countery) {

            $address = Address::where('user_id', $id)->first();
            if ($address) {
                $address->update([
                    'countery' => $request['countery'],
                    'city' => $request['city'],
                    'address_address' => $request['address_address'],
                    'address_latitude' => $request['address_latitude'],
                    'address_longitude' => $request['address_longitude'],
                ]);
            } else {
                Address::create([
                    'user_id' => Auth::guard('provider')->user()->id,
                    'countery' => $request['countery'],
                    'city' => $request['city'],
                    'neigh' => $request['neigh'],
                    'street' => $request['street'],
                    'address_address' => $request['address_address'],
                    'address_latitude' => $request['address_latitude'],
                    'address_longitude' => $request['address_longitude'],
                ]);
            }
        } else {
            $address = null;
        }


        if ($request->bank_account_number) {
            $bank = Bank::where('provider_id', $id)->first();
            if ($bank) {
                $bank->update([
                    'countery' => $request['countery'],
                    'bank_account_number' => $request['bank_account_number'],
                    'IBAN' => $request['IBAN'],
                    'bank_name' => $request['bank_name'],
                    'bank_softcode' => $request['bank_softcode'],
                ]);
            } else {
                Bank::create([
                    'provide_id' => Auth::guard('provider')->user()->id,
                    'countery' => $request['countery'],
                    'bank_account_number' => $request['bank_account_number'],
                    'IBAN' => $request['IBAN'],
                    'bank_name' => $request['bank_name'],
                    'bank_softcode' => $request['bank_softcode'],
                ]);
            }
        } else {
            $bank = null;
        }




        return view('providers.account_information')->with(['provider' => $provider, 'address' => $address, 'bank' => $bank]);
    }

    public function confirm()
    {
        $id = Auth::guard('provider')->user()->id;
        $trips = Trip::query()
            ->join('providers', 'providers.id', 'trips.provider_id')
            ->where('trips.provider_id', $id)
            ->where('providers.service_id', '1')
            ->pluck('trips.id');
        $reservations = Reseervation::whereIn('trip_id', $trips)->paginate('10');
        // $reservations = Reseervation::getFullReservationsDetails($id);
        // dd($reservations);
        return view('providers.reservation.conform')->with('reservations', $reservations);
    }
    public function cancle_All()
    {
        $id = Auth::guard('provider')->user()->id;
        $reservations = Reseervation::where('provider_id', $id)->where('status', 'cancel')->paginate('10');
        // dd($reservations);

        return view('providers.reservation.cancles')->with('reservations', $reservations);
    }
    public function posts()
    {
        $id = Auth::guard('provider')->user()->id;
        $reservations = Reseervation::where('provider_id', $id)->where('status', 'postpone')->paginate('10');
        // dd($reservations);

        return view('providers.reservation.posts')->with('reservations', $reservations);
    }
    public function confirm_car()
    {
        $id = Auth::guard('provider')->user()->id;
        $reservations = Reseervation::where('provider_id', $id)->paginate('10');
        // dd($reservation);

        return view('providers.reservation.confirm')->with('reservations', $reservations);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postpone($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $marketer = Marketer::where('id', $reservation->marketer_id)->first();
        $code = null;
        $marketer ? $code = $marketer->code : $code = null;


        return view('providers.reservation.postpone')->with(['reservation' => $reservation, 'code' => $code]);
    }
    public function postpone_car($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        // $marketer=Marketer::where('code',$reservation->code)->first();
        // $code=$marketer->code;

        // dd($reservation);

        return view('providers.reservation.postpone_car')->with(['reservation' => $reservation]);
    }

    public function storePostpone(Request $request)
    {
        $pid = Auth::guard('provider')->user()->id;
        $preseervation = Reseervation::where(['id' => $request->id, 'provider_id' => $pid])->first();
        $this->authorize('postpone', $preseervation);

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


        $preseervation->date = $request->date;
        $preseervation->day = $request->day;
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
                $to = $reservation->passenger_phone_yem;
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
                $to = $reservation->passenger_phone_yem;
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





        /*  DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }*/
        $date = Carbon::parse($preseervation->date)->format('Y-m-d');

        return response()->json(['url' => route('provider.reservations.confirmAll'), 'msge' => 'success']);


        /* return redirect()
        ->back()
        ->with('success', ' تم تأجيل الحجز ');*/
    }

    public function storePostpone_car(Request $request)
    {
        $pid = Auth::guard('provider')->user()->id;
        $preseervation = Reseervation::where(['id' => $request->id, 'provider_id' => $pid])->first();
        $this->authorize('postpone', $preseervation);

        $data = $request->all();


        $preseervation->date = $request->date;
        $preseervation->day = $request->day;
        $preseervation->note = $request->note;
        $preseervation->status = 'postpone';
        $preseervation->save();


        //    $marketer=Marketer::where('code',$preseervation->code)->first();



        $currency = $preseervation->currency == 'sar' ? 'سعودي' : 'يمني';
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new PostponeReservation($preseervation));

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
                $to = $reservation->passenger_phone_yem;
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
                $to = $reservation->passenger_phone_yem;
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





        /*  DB::commit();
   
           } catch (Throwable $e) {
               DB::rollBack();
               throw $e;
           }*/
        $date = Carbon::parse($preseervation->date)->format('Y-m-d');

        return response()->json(['url' => route('provider.reservations.confirmAll'), 'msge' => 'success']);


        /* return redirect()
           ->back()
           ->with('success', ' تم تأجيل الحجز ');*/
    }
    public function updateCarInfoForm()
    {

        $id =  auth()->guard('provider')->user()->id;
        $provider = Provider::where('id', $id)->first();
        // dd($provider->car_img);

        return view('providers.car_info')->with(['provider' => $provider]);
    }

    public function UpdateCarInfo(Request $request)
    {
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

        $id = auth()->guard('provider')->user()->id;
        $provider = Provider::where('id', $id)->first();

        if ($request['password']) {
            $provider->password = Hash::make($request['password']);
        }
        $provider->update([
            'email' => $request['email'],
            'name_company' => $request['name_company'],
            'city' => $request['city'],
        ]);
        if ($request->phone) {
            $provider->phone = $phone;
        } else {
            $provider->y_phone = $phoneProv;
        }

        if ($request->countery) {

            $address = Address::where('user_id', $id)->first();
            if ($address) {
                $address->update([
                    'countery' => $request['countery'],
                    'city' => $request['city'],
                    'address_address' => $request['address_address'],
                    'address_latitude' => $request['address_latitude'],
                    'address_longitude' => $request['address_longitude'],
                ]);
            } else {
                Address::create([
                    'user_id' => Auth::guard('provider')->user()->id,
                    'countery' => $request['countery'],
                    'city' => $request['city'],
                    'neigh' => $request['neigh'],
                    'street' => $request['street'],
                    'address_address' => $request['address_address'],
                    'address_latitude' => $request['address_latitude'],
                    'address_longitude' => $request['address_longitude'],
                ]);
            }
        } else {
            $address = null;
        }


        if ($request->bank_account_number) {
            $bank = Bank::where('provider_id', $id)->first();
            if ($bank) {
                $bank->update([
                    'countery' => $request['countery'],
                    'bank_account_number' => $request['bank_account_number'],
                    'IBAN' => $request['IBAN'],
                    'bank_name' => $request['bank_name'],
                    'bank_softcode' => $request['bank_softcode'],
                ]);
            } else {
                Bank::create([
                    'provide_id' => Auth::guard('provider')->user()->id,
                    'countery' => $request['countery'],
                    'bank_account_number' => $request['bank_account_number'],
                    'IBAN' => $request['IBAN'],
                    'bank_name' => $request['bank_name'],
                    'bank_softcode' => $request['bank_softcode'],
                ]);
            }
        } else {
            $bank = null;
        }




        return view('providers.account_information')->with(['provider' => $provider, 'address' => $address, 'bank' => $bank]);
    }

    //cancel reservation

    public function cancel($id)
    {
        // dd($id);
        $reservation = Reseervation::findOrFail($id);
        $reservation->update(['status' => 'canceled']);
        // dd($reservation);
        return redirect()->back()->with(['success' => 'تم الغاء الطلب بنجاح']);
        // $marketer = Marketer::where('id', $reservation->marketer_id)->first();
        // $code = null;
        // $marketer ? $code = $marketer->code : $code = null;

        // return view('providers.reservation.cancel')->with(['reservation' => $reservation, 'code' => $code]);
    }

    public function cancel_car($id)
    {
        $reservation = Reseervation::where('id', $id)->first();


        return view('providers.reservation.cancel')->with(['reservation' => $reservation]);
    }

    public function storeCancel(Request $request)
    {
        $pid = Auth::guard('provider')->user()->id;
        $reservation = Reseervation::where(['id' => $request->id])->first();
        $this->authorize('cancel', $reservation);

        $reservation->status = 'cancel';
        $reservation->save();
        $data = $request->all();

        // DB::beginTransaction();
        // try {
        //save to db table reseervations 
        /*   request()->validate([
'passenger_phone'=>['regex:/^(009665|9665|\+9665|05)(5|0|3|6|4|9|1)([0-9]{7})$/i','required_without:passenger_phone_yem','nullable'],

'passenger_phone_yem'=>['regex:/^(00967|967|\+967)([0-9]{9})$/i','required_without:passenger_phone','nullable'],
             'currency' => ['required', 'string', Rule::in(['sar','yer'])], 
        

    ], [
 'passenger_phone.regex'=>'الرقم غير صحيح',
'passenger_phone.required_without'=>'يجب ادخال احد الرقمين',
'passenger_phone_yem.regex'=>'الرقم غير صحيح',
'passenger_phone_yem.required_without'=>'يجب ادخال احد الرقمين',
       
    ]);
*/



        $provider_phone = Provider::where('id', $reservation->provider_id)->first();

        $currency = $reservation->currency == 'sar' ? 'سعودي' : 'يمني';
        $marketer = Marketer::where('code', $reservation->code)->first();
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new CancelReservation($reservation));
        if ($marketer->email) {
            // Send mail to marketer
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
            $provider_phone = Provider::where('id', $reservation->provider_id)->first()->phone;
            $provider_phone_y = Provider::where('id', $reservation->provider_id)->first()->y_phone;
            if ($provider_phone) {
                $this->sendSASMS($provider_phone, $body_full);
            }
            if ($provider_phone_y) {
                $this->sendYESMS($provider_phone_y, $body_full);
            }
            // $this->smsSend($reservation->amount,$currency,$marketer->max_rs,$reservation->order_id,$reservation->order_url,$provider_phone);
            //sendSASMS($provider_phone,$body_full);


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
            // $this->smsSend($reservation->amount,$currency,$marketer->max_rs,$reservation->order_id,$reservation->order_url,$provider_phone);


        }

        /*  DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }*/
        return response()->json(['url' => route('provider.reservations.confirmAll'), 'msge' => 'success']);
    }

    public function storeCancel_car(Request $request)
    {
        $pid = Auth::guard('provider')->user()->id;
        $reservation = Reseervation::where(['id' => $request->id])->first();
        $this->authorize('cancel', $reservation);

        $reservation->status = 'cancel';
        $reservation->save();
        $data = $request->all();




        $provider_phone = Provider::where('id', $reservation->provider_id)->first();

        $currency = $reservation->currency == 'sar' ? 'سعودي' : 'يمني';
        // Send mail to admin

        $mailToAdmin = Admin::where('id', 1)->first()->email;
        Mail::to($mailToAdmin)->send(new CancelReservation($reservation));

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
            $provider_phone = Provider::where('id', $reservation->provider_id)->first()->phone;
            $provider_phone_y = Provider::where('id', $reservation->provider_id)->first()->y_phone;
            if ($provider_phone) {
                $this->sendSASMS($provider_phone, $body_full);
            }
            if ($provider_phone_y) {
                $this->sendYESMS($provider_phone_y, $body_full);
            }
            // $this->smsSend($reservation->amount,$currency,$marketer->max_rs,$reservation->order_id,$reservation->order_url,$provider_phone);
            //sendSASMS($provider_phone,$body_full);


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
            // $this->smsSend($reservation->amount,$currency,$marketer->max_rs,$reservation->order_id,$reservation->order_url,$provider_phone);


        }

        /*  DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }*/
        return response()->json(['url' => route('provider.reservations.confirmAll'), 'msge' => 'success']);
    }
    //postpone reservation
    public function transfer($id)
    {
        $reservation = Reseervation::where('id', $id)->first();
        $marketer = Marketer::where('id', $reservation->marketer_id)->first();
        $code = null;
        $marketer ? $code = $marketer->code : $code = null;

        $provide_name = $marketer->provide;
        $provide = Provider::where('name_company', $provide_name)->first();

        $provide =  $marketer->provide;
        if ($provide == 'global') {
            $companies =  Provider::all();
        } else {
            $comp = $marketer->provide;
            $companies =  Provider::where('name_company', $comp)->get();
        }


        return view('providers.reservation.transfer')->with(['reservation' => $reservation, 'code' => $code, 'companies' => $companies]);
    }
    public function transfer_car($id)
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


        return view('providers.reservation.transfer')->with(['reservation' => $reservation, 'code' => $code, 'companies' => $companies]);
    }


    public function storeTransfer(Request $request)
    {

        $data = $request->all();

        $pid = Auth::guard('provider')->user()->id;

        $preseervation = Reseervation::where('id', $request->id)->first();

        //  $this->authorize('storetransfer',$preseervation);
        /*
     $validator = Validator::make($request->all(), [
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
    ]);
          if ($validator->passes()) {
*/
        $tpr = Provider::where('id', $preseervation->provider_id)->first();


        $tid = $preseervation->trip_id;
        $tday = $preseervation->day;
        $tdate = Carbon::parse($preseervation->date)->format('m-d');

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

        if ($marketer->email) {  // Send mail to marketer
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


        //send sms to passenger phone
        /*$this->smsTransferSend($preseervation->amount,$currency,$marketer->max_rs,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
                // send sms to provider phone
                $provider_phone = Provider::where('id',$preseervation->provider_id)->first()->phone;
                $this->smsTransferSend($preseervation->amount,$currency,$marketer->max_rs,$preseervation->order_id,$preseervation->order_url,$preseervation->passenger_phone,$preseervation->date);
    
*/
        $provider_phone1 = Provider::where('id', $tpr->id)->first()->phone;
        $provider_phone1_y = Provider::where('id', $tpr->id)->first()->y_phone;
        $provider_phone2_y = Provider::where('id', $preseervation->provider_id)->first()->y_phone;
        $provider_phone2 = Provider::where('id', $preseervation->provider_id)->first()->phone;

        if ($preseervation->passenger_phone) {
            $this->sendSASMS($preseervation->passenger_phone, $msgP);
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

        $marketer = Marketer::where('code', $preseervation->code)->first();


        // Send mail to admin


        //send sms to passenger phone





        /*  DB::commit();

    } catch (Throwable $e) {
        DB::rollBack();
        throw $e;
    }*/

        return response()->json(['url' => route('provider.reservations.confirmAll'), 'msge' => 'success']);
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


    public function sms($id = null)
    {
        if ($id) {
            $reservation = Reseervation::where('id', $id)->first();
            return view('providers.sms')->with(['reservation' => $reservation]);
        }
        $reservation = null;
        return view('providers.sms')->with(['reservation' => $reservation]);
    }
    public function storeSms(SmsRequest $request)
    {

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

        if ($request->passenger_phone_yem) {
            $to = $passenger_phone_yem;
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




        return back()->with('success', 'تم ارسال رسال الى العميل ');
    }



    /* public function test(){
        $this->smsSend(500, 'ser', '+970599342567');
    }*/







    /* public function test(){
        $this->smsSend(500, 'ser', '+970599342567');
    }*/





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

        return view('providers.reservation.update')->with([
            'reservation' => $reservation,
            'bus_trips' => $bus_trips,
            'marketers' => $marketers,
        ]);
        // $reservation = Reseervation::where('id', $id)->first();
        // dd($reservation);
        // return view('providers.reservation.update')->with(['reservation' => $reservation]);
    }
    public function passengersList($id)
    {
        $passengers = TripOrderPassenger::where('reservation_id', $id)->get();
        // dd($reservation);
        return view('providers.reservation.passengersList')->with(['passengers' => $passengers]);
    }

    public function savePassengersTickets(Request $request)
    {
        foreach ($request->external_ticket_no as $key => $item) {
            // dd($request->id[$key]);
            TripOrderPassenger::where('id', $request->id[$key])->update([
                'external_ticket_no' => $item
            ]);
        }

        // return response()->json(['url' => route('provider.reservations.confirmAll'), 'msge' => 'success']);
        return redirect()->back()->with(['info' => 'تم حفظ ارقام التزاكر']);
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


        return redirect()->route('provider.reservations.confirmAll')->with(['success' => 'تم تعديل بيانات الحجز بنجاح']);
    }
    public function downloadImage($id)
    {
        $reservation = Reseervation::where('id', $id)->firstOrFail();
        $path = public_path() . '/images/reservation/' . $reservation->image;
        return response()->download($path, $reservation
            ->original_filename, ['Content-Type' => $reservation->mime]);
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
