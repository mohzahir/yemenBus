<?php

namespace App\Http\Controllers\Passenger;

use App\Trip;
use Throwable;
use App\TripOrder;
use App\TripOrderPassenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\HajCheckoutRequest;
use App\Http\Requests\HajPaymentRequest;
use App\Mail\ConfirmReservation;
use App\Mail\TransferReservation;
use App\Notifications\ReservationDone;
use App\Passenger;
use App\Reseervation;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use TelrGateway\Transaction;

class TripCheckoutController extends Controller
{
    public function tripOrder(Request $request, $tripId)
    {
        ddd($request);
        $rules = [];
        $seatNo = 0;
        foreach ($request->input('name') as $key => $value) {
            $rules["name.{$key}"] = 'required|string|min:3|max:50';
            $seatNo = $key + 1;
        }
        //return $seatNo;
        $rules['phone'] = 'required|numeric|digits:9'; // for yemen 967-767-890-965 ,sa -> 966-531-066-035 ,
        $rules['email'] = 'nullable|email';
        $rules['notes'] = 'nullable|string|max:1500';

        $validator = Validator::make($request->all(), $rules);

        $phoneIntro = $request->input('phoneCountry') == 's' ? '+966' : '+967';
        $phoneIntroS = '+966';
        $phoneIntroY = '+967';

        if ($validator->passes()) {

            DB::beginTransaction();

            try {

                // create order 
                $trip = Trip::findOrFail($tripId);

                $total = (float)$trip->price * ((int)$seatNo);


                // var_dump($tripId);exit;

                $order = TripOrder::create([
                    'trip_id' => $tripId,
                    's_phone' => $request->phoneCountry == 's' ? '966' . $request->phone : null,
                    'y_phone' => $request->phoneCountry == 'y' ? '967' . $request->phone : null,
                    'email' => $request->email,
                    'notes' => $request->notes,
                    'ticket_no' =>  $seatNo,
                    'price' => $trip->price,
                    'total' => $total,
                    'remain' => $this->calcRemainOfPrice($total),
                    'status' => 'created',

                ]);

                foreach ($request->input('name') as $key => $value) {

                    TripOrderPassenger::create([
                        'trip_id' => $trip->id,
                        'trip_ordrer_id' => $order->id,
                        'name' => $request->input('name')[$key],
                        'phone' =>  $phoneIntro . $request->input('phone'),
                        'age' => $request->input('age')[$key],
                        'gender' => $request->input('gender')[$key],
                        'p_id' => $request->input('nid')[$key],
                    ]);
                }

                $reseervation = new  Reseervation();
                $reseervation->order_id = $order->id;

                $reseervation->order_url = "$request->order_url";

                $reseervation->passenger_name = $request->input('name')[0];

                $reseervation->passenger_phone = $phoneIntroS . $request->input('phone');
                $reseervation->passenger_phone_yem = $phoneIntroY . $request->input('phone');

                $reseervation->provider_id = $trip->provider_id;
                $reseervation->amount = $total;
                $reseervation->amount_deposit = $trip->price;

                $reseervation->day = $trip->day;
                $reseervation->date = $trip->created_at;

                $reseervation->code = $trip->id;

                $reseervation->from_city = $trip->from;
                $reseervation->to_city = $trip->to;

                $reseervation->ticket_no = $trip->no_ticket;

                $reseervation->currency = '';
                $reseervation->amount_type = '';
                // var_dump($reseervation->save());exit;

                $reseervation->save();

                DB::commit(); //966507703877

                $body = 'حجوزات يمن باص رقم الحجز: ' . $order->id . ' يمكنك المتابعه على الرابط التالي :https://www.yemenbus.com/passengers/order/' . $order->id;

                $order->s_phone != null ? $this->sendSASMS($order->s_phone, $body) : $this->sendYESMS($order->y_phone, $body);

                return redirect()->route('passengers.tripPayment', [
                    'trip' => $trip->id,
                    'triprOder' => $order->id,
                ]);
            } catch (Throwable $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function myTripOrder(Request $request, $tripId)
    {
        // dd($request->all());
        $rules = [];
        $seatCount = 0;
        foreach ($request->input('name') as $key => $value) {
            $rules["name.{$key}"] = 'required|string|min:3|max:50';
            $rules["dateofbirth.{$key}"] = 'required|date';
            $rules["gender.{$key}"] = 'required';
            $rules["age.{$key}"] = 'required';
            $seatCount = $key + 1;
        }
        //return $seatCount;
        $rules['phone'] = 'required|numeric|digits:9'; // for yemen 967-767-890-965 ,sa -> 966-531-066-035 ,
        $rules['email'] = 'nullable|email';
        $rules['ride_place'] = 'nullable|string';
        $rules['drop_place'] = 'nullable|string';
        $rules['notes'] = 'nullable|string|max:1500';
        $rules['privacy_check'] = 'required|in:1';

        $validator = Validator::make($request->all(), $rules, ['privacy_check.required' => 'يجب عليك الموافقة على الشروط والاحكام']);

        switch ($request->input('phoneCountry')) {
            case 's':
                $phone = '+966' . $request->phone;
                break;
            case 'y':
                $phone = '+967' . $request->phone;
                break;
            case 'e':
                $phone = '+971' . $request->phone;
                break;
        }
        // $phone = $request->input('phoneCountry') == 's' ? '+966' . $request->phone : '+967' . $request->phone;
        // $phone = '249927942031';

        if ($validator->passes()) {

            // dd($request->all());

            DB::beginTransaction();

            try {
                // DB::transaction(function () use ($seatCount, $request, $tripId, $phone) {

                $phoneColumnName = $request->input('phoneCountry') == 's' || $request->input('phoneCountry') == 'e' ? 'phone' : 'y_phone';
                if (Auth::guard('passenger')->check()) {
                    //user is authentecated
                    $passenger_id = Auth::guard('passenger')->user()->id;
                    $passenger = Passenger::findOrFail($passenger_id);
                    $passenger->update([$phoneColumnName => $phone]);
                } else {
                    //user is not authenticated
                    $passport_img = null;
                    if ($request->hasFile('passport_img')) {
                        $passport_img = $request->file('passport_img')->store('files', 'public_folder');
                    }
                    $passenger = Passenger::where($phoneColumnName, $phone)->first();
                    if (!$passenger) {
                        //passenger is not registered
                        $passenger = Passenger::create([
                            'email' => $request->email,
                            'name_passenger' => $request->name[0],
                            'passport_img' => $passport_img,
                            $phoneColumnName => $phone
                        ]);
                    }
                }

                // create reservation 
                $trip = Trip::findOrFail($tripId);

                $total = (float)$trip->price * ((int)$seatCount);


                // var_dump($tripId);exit;

                $reservation = Reseervation::create([
                    // 'id' => Str::uuid()->toString(),
                    'trip_id' => $tripId,
                    'marketer_id' => null,
                    'main_passenger_id' => $passenger->id,
                    'ride_place' => $request->ride_place,
                    'drop_place' => $request->drop_place,
                    'ticket_no' =>  $seatCount,
                    'payment_method' =>  null,
                    'payment_time' =>  null,
                    'payment_type' =>  null,
                    'total_price' =>  $total,
                    'paid' => null,
                    'currency' => null,
                    'note' => $request->notes,
                    'status' => 'created',
                    // 's_phone' => $request->phoneCountry == 's' ? '966' . $request->phone : null,
                    // 'y_phone' => $request->phoneCountry == 'y' ? '967' . $request->phone : null,
                    // 'email' => $request->email,
                    // 'price' => $trip->price,
                    // 'remain' => $this->calcRemainOfPrice($total),
                ]);

                foreach ($request->input('name') as $key => $value) {

                    // $dateOfBirth = "";
                    // if (count($request->dateofbirth[$key]) > 0) {
                    //     foreach ($request->dateofbirth[$key] as $birth_key => $value) {
                    //         if ($birth_key == 2) {
                    //             $dateOfBirth .= $value;
                    //         } else {
                    //             $dateOfBirth .= $value . '-';
                    //         }
                    //     }
                    //     $dateOfBirth = Carbon::createFromFormat('d-m-Y', $dateOfBirth)
                    //         ->format('Y-m-d');
                    // }
                    // dd($dateOfBirth);

                    TripOrderPassenger::create([
                        // 'trip_id' => $trip->id,
                        'reservation_id' => $reservation->id,
                        'external_ticket_no' => null,
                        'p_id' => $request->input('nid')[$key],
                        'dateofbirth' => date('Y-m-d', strtotime($request->dateofbirth[$key])),
                        'age' => $request->input('age')[$key],
                        'gender' => $request->input('gender')[$key],
                        'phone' => $request->input('phone'),
                        'name' => $request->input('name')[$key],
                    ]);
                }
                DB::commit(); //966507703877

                $body = 'حجوزات يمن باص رقم الحجز: ' . $reservation->id . ' يمكنك المتابعه على الرابط التالي :https://www.yemenbus.com/passengers/order/' . $reservation->id;

                switch ($request->input('phoneCountry')) {
                    case 's':
                        $this->sendSASMS($phone, $body);
                        break;
                    case 'y':
                        $this->sendYESMS($phone, $body);
                        break;
                    case 'e':
                        // $this->sendYESMS($phone, $body)
                        break;
                }
                $request->phoneCountry == 's' ? $this->sendSASMS($phone, $body) : $this->sendYESMS($phone, $body);

                // Send mail to passenger
                if ($reservation->passenger->email || $request->email) {
                    Mail::to($reservation->passenger->email)->send(new ConfirmReservation($reservation));
                }

                //send whatsapp notification
                $passenger->notify(new ReservationDone($reservation));
                // });

                return redirect()->route('passengers.tripPayment', [
                    'trip' => $tripId,
                    'reservation' => $reservation->id,
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function tripPayment(Trip $trip, Reseervation $reservation)
    {
        return view('passengers.payment')->with([
            'trip' => $trip,
            'order' => $reservation,
        ]);
    }

    public function tripCheckout(Request $request, $id)
    {
        // ddd($request->all());
        $this->checkRequest($request);
        //return $request->all();
        DB::beginTransaction();

        try {
            $reservation = Reseervation::where('id', $id)->first();
            $trip = Trip::find($reservation->trip_id);

            $payment_method = $request->payment_type == 'later_payment' ? 'inBus' : $request->paymentType;

            $BUS_RS_DEPOSIT_VALUE = Setting::where('key', 'BUS_RS_DEPOSIT_VALUE')->first()->value;
            $BUS_RY_DEPOSIT_VALUE = Setting::where('key', 'BUS_RY_DEPOSIT_VALUE')->first()->value;
            $deposit = $trip->deposit_price ? $trip->deposit_price : ($request->currency == 'rs' ? $BUS_RS_DEPOSIT_VALUE : $BUS_RY_DEPOSIT_VALUE);
            $price = $request->payment_type == 'total_payment' ? $reservation->total_price : ($request->payment_type == 'deposit_payment' ? $deposit : 0);


            //check if there are tickets available in trip 
            if ($trip->no_ticket > $reservation->ticket_no) {
                //progress

                $payment_image = null;
                if ($request->payment_image) {
                    $payment_image = $request->file('payment_image')->store('files', 'public_folder');
                }

                $reservation->update([
                    //    'passenger_id' => Auth::guard('passenger')->id() ,
                    'payment_type' => $request->payment_type, // ['total_payment','deposit_payment','later_payment'])->default('later_payment')
                    'payment_method' => $payment_method, //['telr','bank','inBus'])->default('inBus')
                    'payment_time' => date('Y-m-d H:i:s'),
                    'payment_image' => $payment_image,
                    'paid' => $price,
                    'currency' => $trip->currency,
                    'status' => 'created',

                ]);

                // $trip->update([
                //     'no_ticket' => ($trip->no_ticket - $reservation->ticket_no),
                // ]);

                DB::commit();

                if ($payment_method == 'telr') {
                    return  $this->telrPay($reservation->id, $price, $reservation->trip_id);
                } else {

                    return redirect()->route('passengers.orderDetails', [
                        'id' => $reservation->id,
                    ]);
                }
            } else {
                //alert error
                return redirect()->route('passengers.cards');
            }
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }



    //haj section 
    public function hajCheckout($id)
    {
        $trip = Trip::findOrFail($id);
        // dd($reservation);
        $omra_deposit = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;
        $haj_deposit = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;
        return view('passengers.haj_checkout', [
            'trip' => $trip,
            'omra_deposit_value' => $omra_deposit,
            'haj_deposit_value' => $haj_deposit,
        ]);
    }

    public function storeHajCheckout(HajCheckoutRequest $request, $tripId)
    {
        $trip = Trip::findOrFail($tripId);

        $dateOfBirth = "";
        if ($request->dateofbirth[0] && $request->dateofbirth[1] && $request->dateofbirth[2]) {
            foreach ($request->dateofbirth as $key => $value) {
                if ($key == 2) {
                    $dateOfBirth .= $value;
                } else {
                    $dateOfBirth .= $value . '-';
                }
            }
            $dateOfBirth = Carbon::createFromFormat('d-m-Y', $dateOfBirth)
                ->format('Y-m-d');
        }
        // dd($request, $dateOfBirth);

        $file = null;
        if ($request->hasFile('passport_img')) {
            $file = $request->passport_img->store('files', 'public_folder');
        }

        $phone = $request->input('phoneCountry') == 's' ? '+966' . $request->phone : '+967' . $request->phone;

        DB::beginTransaction();
        try {
            // if (Auth::guard('passenger')->check()) {
            //     $passenger = Auth::guard('passenger')->user();
            // } else {
            //     $passenger = Passenger::where('email', $request->email)->first();
            //     if (!$passenger) {
            //         $phoneColumnName = $request->input('phoneCountry') == 's' ? 'phone' : 'y_phone';
            //         $passenger = Passenger::create([
            //             'email' => $request->email,
            //             'name_passenger' => $request->name,
            //             $phoneColumnName => $phone,
            //             'age' => $request->age,
            //             'dateofbirth' => $dateOfBirth,
            //             'p_id' => $request->nid,
            //             'passport_img' => $file,
            //         ]);
            //     }
            // }

            if (Auth::guard('passenger')->check()) {
                //user is authentecated
                $passenger = Auth::guard('passenger')->user();
            } else {
                //user is not authenticated
                $phoneColumnName = $request->input('phoneCountry') == 's' ? 'phone' : 'y_phone';
                $passenger = Passenger::where($phoneColumnName, $phone)->first();
                if (!$passenger) {
                    //passenger is not registered
                    $passenger = Passenger::create([
                        'email' => $request->email,
                        'name_passenger' => $request->name,
                        $phoneColumnName => $phone,
                        'age' => $request->age,
                        'dateofbirth' => $dateOfBirth,
                        'p_id' => $request->nid,
                        'passport_img' => $file,
                    ]);
                }
            }



            $reservation = Reseervation::create([
                // 'id' => Str::uuid()->toString(),
                'trip_id' => $tripId,
                'marketer_id' => null,
                'main_passenger_id' => $passenger->id,
                'ride_place' => $request->ride_place,
                'drop_place' => $request->drop_place,
                'ticket_no' =>  1,
                'payment_method' =>  null,
                'payment_time' =>  null,
                'payment_type' =>  null,
                'total_price' =>  $trip->price,
                'paid' => 0,
                'currency' => null,
                // 'note' => $request->notes,
                'status' => 'created',
                // 's_phone' => $request->phoneCountry == 's' ? '966' . $request->phone : null,
                // 'y_phone' => $request->phoneCountry == 'y' ? '967' . $request->phone : null,
                // 'email' => $request->email,
                // 'price' => $trip->price,
                // 'remain' => $this->calcRemainOfPrice($total),

            ]);

            DB::commit(); //966507703877

            $body = 'حجوزات يمن باص رقم الحجز: ' . $reservation->id . ' يمكنك المتابعه على الرابط التالي :https://www.yemenbus.com/passengers/order/' . $reservation->id;

            // $reservation->s_phone != null ? $this->sendSASMS($reservation->s_phone, $body) : $this->sendYESMS($reservation->y_phone, $body);

            $request->phoneCountry == 's' ? $this->sendSASMS($phone, $body) : $this->sendYESMS($phone, $body);

            return redirect()->route('passengers.hajPayment', [
                'reservationId' => $reservation->id,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function hajPayment($reservationId)
    {
        $reservation = Reseervation::findOrFail($reservationId);
        $omra_deposit = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;
        $haj_deposit = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;


        return view('passengers.haj_payment', [
            'reservation' => $reservation,
            'omra_deposit_value' => $omra_deposit,
            'haj_deposit_value' => $haj_deposit,
        ]);
    }

    public function storeHajPayment(HajPaymentRequest $request, $reservation_id)
    {
        $reservation = Reseervation::findOrFail($reservation_id);
        $reservation->update([
            'payment_type' => $request->payment_type
        ]);
        return redirect()->route('passengers.hajPaymentGateway', ['reservationId' => $reservation_id]);
        // $isOmra = $reservation->sub_service_id == 1 ? true : false;
        // dd( Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT'));
        // $omra_deposit = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;
        // $haj_deposit = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;
        // $price = ($request->payment_type == 'total_payment' ? $reservation->trip->price : ($isOmra ? $omra_deposit : $haj_deposit));
        // $reservation->update([
        //     'payment_type' => $request->payment_type, // ['total_payment','deposit_payment','later_payment'])->default('later_payment')
        //     'payment_method' => $request->payment_method, //['telr','bank','inBus'])->default('inBus')
        // ]);
        // if ($request->payment_method == 'telr') {
        // $url = $this->telrPay($reservation->id, $price, $reservation->trip->id);

        //     return  $this->telrPay($reservation->id, $price, $reservation->trip->id);
        // } else {
        // }
    }

    public function hajPaymentGateway($reservationId)
    {
        $reservation = Reseervation::findOrFail($reservationId);


        //copied code
        $telrManager = new \TelrGateway\TelrManager();

        $isOmra = $reservation->sub_service_id == 1 ? true : false;
        $omra_deposit = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;
        $haj_deposit = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;
        $deposit = $reservation->trip->deposit_price ? $reservation->trip->deposit_price : ($isOmra ? $omra_deposit : $haj_deposit);

        $total = ($reservation->payment_type == 'total_payment' ? $reservation->trip->price : $deposit);
        $billingParams = [
            'first_name' => 'Abc',
            'sur_name' => 'Xyz',
            'address_1' => 'Test Address',
            'address_2' => 'Test Address 2',
            'city' => 'Dubai',
            'zip' => 123456,
            'country' => 'UAE',
            'phone' => $reservation->passenger->phone ?? '966 50 727 6370',
            'email' => 'testTelr@gmail.com',
        ];

        $url_link = $telrManager->pay($reservationId, $total, 'Telr Test Payment Details', $billingParams)->redirect();
        $url = $url_link->getTargetUrl();
        //copied code

        return view('passengers.haj_payment_gateway', [
            'reservation' => $reservation,
            'url' => $url,
            'omra_deposit_value' => $omra_deposit,
            'haj_deposit_value' => $haj_deposit,
        ]);
    }

    public function storeHajBankPayment(Request $request, $reservation_id)
    {
        $request->validate([
            'payment_method' => 'required|in:telr,bank',
            'payment_image' => 'required',
        ]);

        $payment_image = $request->file('payment_image')->store('files');
        $reservation = Reseervation::findOrFail($reservation_id);

        $reservation->update([
            'payment_method' => $request->payment_method,
            'payment_image' => $payment_image,
            'status' => 'created',
        ]);

        $body = 'حجوزات يمن باص رقم الحجز: ' . $reservation->id . ' تم تاكيد حجزك للمتابعة
        :https://www.yemenbus.com/passengers/order/' . $reservation->id;

        // $reservation->s_phone != null ? $this->sendSASMS($reservation->s_phone, $body) : $this->sendYESMS($reservation->y_phone, $body);
        $reservation->passenger->phone ? $this->sendSASMS($reservation->passenger->phone, $body) : $this->sendYESMS($reservation->passenger->y_phone, $body);

        // Send mail to passenger
        if ($reservation->passenger->email) {
            // $mailToMarketer = $marketer->email;
            Mail::to($reservation->passenger->email)->send(new ConfirmReservation($reservation));
        }

        return redirect()->route('passengers.orderDetails', [
            'id' => $reservation_id,
        ]);
    }


    //end haj section


    protected function calcRemainOfPrice($total)
    {
        return $payedPrice = ((float)$total * 20) / 100;
    }

    protected function checkRequest(Request $request)
    {
        $request->validate([
            'payment_type' => 'nullable|string|in:total_payment,deposit_payment,later_payment', // ['f','p','n'])->default('n')
            'payment_method' => 'nullable|string|in:telr,bank,inBus,paypal', //['telr','bank'])->default('bank')
            'payment_image' => 'nullable',

        ]);
    }

    public function telrPay($reservationId, $price, $tripId)
    {
        $telrManager = new \TelrGateway\TelrManager();
        $reservation = Reseervation::findOrFail($reservationId);
        // $trip = Trip::getTripDetails($tripId);
        // $billingParams = [
        //     'first_name' => 'Moustafa Gouda',
        //     'city' => 'Alexandria',
        //     'region' => 'San Stefano',
        //     'country' => 'EG',
        // ];
        $billingParams = [
            'first_name' => 'Abc',
            'sur_name' => 'Xyz',
            'address_1' => 'Test Address',
            'address_2' => 'Test Address 2',
            'city' => 'Dubai',
            'zip' => 123456,
            'country' => 'UAE',
            'phone' => $reservation->passenger->phone ?? '966 50 727 6370',
            'email' => 'testTelr@gmail.com',
        ];

        //  session()->put('total', $price);
        // session()->put('reservation_id', $reservationId);
        // session()->put('trip_id', $tripId);


        return $telrManager->pay($reservationId, $price, 'Telr payment ...', $billingParams)->redirect();
    }

    public function success(Request $request)
    {
        /* $telrManager = new \TelrGateway\TelrManager();
        return $telrManager->handleTransactionResponse($request);*/
        // $reservation_id = session()->get('reservation_id');
        $transaction = Transaction::where('cart_id', $request->cart_id)->first();

        $reservation = Reseervation::find($transaction->order_id);
        $reservation->update([
            'payment_method' => 'telr',
            'payment_time' => date('Y-m-d H:i:s'),
            'paid' => $transaction->amount,
            'currency' => $reservation->trip->currency,
            'status' => 'confirmed',
        ]);


        $body = 'حجوزات يمن باص رقم الحجز: ' . $reservation->id . ' تم تاكيد حجزك للمتابعة
        :https://www.yemenbus.com/passengers/order/' . $reservation->id;

        // $reservation->s_phone != null ? $this->sendSASMS($reservation->s_phone, $body) : $this->sendYESMS($reservation->y_phone, $body);
        $reservation->passenger->phone ? $this->sendSASMS($reservation->passenger->phone, $body) : $this->sendYESMS($reservation->passenger->y_phone, $body);

        // Send mail to passenger
        if ($reservation->passenger->email) {
            // $mailToMarketer = $marketer->email;
            Mail::to($reservation->passenger->email)->send(new ConfirmReservation($reservation));
        }

        return redirect()->route('passengers.orderDetails', [
            'id' => $transaction->order_id,
        ]);
    }

    public function cancel()
    {
        return redirect('/');
    }
    public function decline()
    {
        $telrManager = new \TelrGateway\TelrManager();
        $telrManager->handleTransactionResponse($request);
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
