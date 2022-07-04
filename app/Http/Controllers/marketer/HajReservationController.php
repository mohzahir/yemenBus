<?php

namespace App\Http\Controllers\marketer;

// use App\Http\Controllers\Controller;
use App\marketer;
use App\Passenger;
use App\Provider;
use App\Reseervation;
use App\Setting;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HajReservationController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $marketer = Auth::guard('marketer')->user();
        // dd($id);
        $reservations = [];
        switch ($marketer->marketer_type) {
            case 'global_marketer':
                $reservations = Reseervation::query()
                    ->join('trips', 'trips.id', 'reseervations.trip_id')
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 3)
                    ->where('reseervations.status', '!=', 'canceled')
                    ->paginate(10);
                break;
            case 'provider_marketer':
                $reservations = Reseervation::query()
                    ->join('trips', 'trips.id', 'reseervations.trip_id')
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 3)
                    ->where('trips.provider_id', $marketer->provider_id)
                    ->where('reseervations.status', '!=', 'canceled')
                    ->paginate(10);
                break;
            case 'service_marketer':
                $providers_ids = Provider::where('service_id', $marketer->service_id)->pluck('id');
                $reservations = Reseervation::query()
                    ->join('trips', 'trips.id', 'reseervations.trip_id')
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 3)
                    ->whereIn('trips.provider_id', $providers_ids)
                    ->where('reseervations.status', '!=', 'canceled')
                    ->paginate(10);
                break;

            default:
                $reservations = [];
                break;
        }
        return view('marketers.haj-reservations.index', compact('reservations'));
    }

    public function show($reservation)
    {
        $reservation = Reseervation::findOrFail($reservation);
        // dd($reservation);

        return view('marketers.haj-reservation.show', ['reservation' => $reservation]);
    }

    public function create()
    {
        $marketer = Auth::guard('marketer')->user();
        // dd($marketer);
        $trips = [];
        switch ($marketer->marketer_type) {
            case 'global_marketer':
                $trips = Trip::query()
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 3)
                    ->where('no_ticket', '>', 0)
                    ->where('status', 'active')->get();
                break;
            case 'provider_marketer':
                $trips = Trip::query()
                    ->join('providers', 'providers.id', 'trips.provider_id')
                    ->where('providers.service_id', 3)
                    ->where('trips.provider_id', $marketer->provider_id)
                    ->where('no_ticket', '>', 0)
                    ->where('status', 'active')->get();
                break;
            case 'service_marketer':
                $providers_ids = Provider::where('service_id', $marketer->service_id)->pluck('id');
                $trips = Trip::query()
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
        // dd($trips);
        return view('marketers.haj-reservations.create')->with(['trips' => $trips, 'marketer' => $marketer]);
    }

    public function store(Request $request)
    {
        // dd($request);
        // $rules = [];
        // $seatCount = 0;
        // foreach ($request->input('name') as $key => $value) {
        //     $rules["name.{$key}"] = 'required|string|min:3|max:50';
        //     $seatCount = $key + 1;
        // }
        // $rules['phone'] = 'required|numeric|digits:9'; 
        // $rules['email'] = 'nullable|email';
        // $rules['notes'] = 'nullable|string|max:1500';

        $validator = Validator::make($request->all(), [
            'trip_id' => 'required',
            "name" => "required",
            "phone" => "required|numeric|digits:9",
            'dateofbirth' => 'required',
            'dateofbirth.*.0' => 'numeric|max:31',
            'dateofbirth.*.1' => 'numeric|max:12',
            'dateofbirth.*.2' => 'numeric|max:2022',
        ]);

        $phone = $request->input('phoneCountry') == 's' ? '+966' . $request->phone : '+967' . $request->phone;

        if ($validator->passes()) {

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

            DB::beginTransaction();

            try {
                $passenger = Passenger::where('email', $request->email)->first();
                if (!$passenger) {
                    //passenger is not registered
                    $phoneColumnName = $request->input('phoneCountry') == 's' ? 'phone' : 'y_phone';
                    $passenger = Passenger::create([
                        'email' => $request->email,
                        'name_passenger' => $request->name[0],
                        $phoneColumnName => $phone,
                        'age' => $request->age,
                        'dateofbirth' => $dateOfBirth,
                        'p_id' => $request->nid,
                        'passport_img' => $file,
                    ]);
                }


                // create reservation 
                $trip = Trip::findOrFail($request->trip_id);

                $marketer = Marketer::findOrFail(auth()->guard('marketer')->user()->id);

                // $total = (float)$trip->price * ((int)$seatCount);

                $HAJ_PROGRAM_RS_DEPOSIT = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;
                $OMRA_PROGRAM_RS_DEPOSIT = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;

                $deposit = ($trip->sub_service_id == '1' ? $OMRA_PROGRAM_RS_DEPOSIT : $HAJ_PROGRAM_RS_DEPOSIT);

                $paid = $request->payment_type == 'total_payment' ? $trip->price : $deposit;

                // dd($paid, $marketer->balance_ry, $request->all(), $trip->currency);
                if (($paid > $marketer->balance_rs)) {

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

                    // return redirect()->back()->withErrors(['error' => 'رصيدك غير كافي لاجراء هذا الحجز الرجاء شحن رصيدك'])->withInput();
                    return redirect()->route('passengers.hajPayment', ['reservationId' => $reservation_id])->with(['warning' => ' رصيدك غير كافي لاجراء هذا الحجز الرجاء شحن رصيدك او مواصلة الحجز من خلال الدفع الالكتروني']);
                }

                // var_dump($tripId);exit;

                $reservation = Reseervation::create([
                    // 'id' => Str::uuid()->toString(),
                    'trip_id' => $request->trip_id,
                    'marketer_id' => auth()->guard('marketer')->user()->id,
                    'main_passenger_id' => $passenger->id,
                    'ticket_no' =>  '1',
                    'payment_method' =>  null,
                    'payment_time' => date('Y-m-d H:i:s'),
                    'payment_type' =>  $request->payment_type,
                    'total_price' =>  $trip->price,
                    'paid' => $paid,
                    'ride_place' => $request->ride_place,
                    'drop_place' => $request->drop_place,
                    'currency' => 'rs',
                    // 'note' => $request->notes,
                    'status' => 'confirmed',
                    // 's_phone' => $request->phoneCountry == 's' ? '966' . $request->phone : null,
                    // 'y_phone' => $request->phoneCountry == 'y' ? '967' . $request->phone : null,
                    // 'email' => $request->email,
                    // 'price' => $trip->price,
                    // 'remain' => $this->calcRemainOfPrice($total),

                ]);

                if ($reservation) {
                    $marketer->update([
                        'balance_rs' => ($marketer->balance_rs - $paid)
                    ]);
                }


                // foreach ($request->input('name') as $key => $value) {

                //     TripOrderPassenger::create([
                //         'reservation_id' => $reservation->id,
                //         'external_ticket_no' => null,
                //         'p_id' => $request->input('nid')[$key],
                //         'dateofbirth' => $request->input('dateofbirth')[$key],
                //         'age' => $request->input('age')[$key],
                //         'gender' => $request->input('gender')[$key],
                //         'phone' => $request->input('phone'),
                //         'name' => $request->input('name')[$key],
                //     ]);
                // }

                DB::commit(); //966507703877

                // $body = 'حجوزات يمن باص رقم الحجز: ' . $reservation->id . ' يمكنك المتابعه على الرابط التالي :https://www.yemenbus.com/passengers/order/' . $reservation->id;

                // $request->phoneCountry == 's' ? $this->sendSASMS($phone, $body) : $this->sendYESMS($phone, $body);

                return redirect()->route('marketer.haj.reservations.create')->with(['success' => ' تم اضافه الحجز بنجاح']);
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function edit(Reseervation $Reseervation)
    {
        //
    }

    public function update($reservation_id)
    {
        // confirm bank reservation 
        $reservation = Reseervation::findOrFail($reservation_id);
        $reservation->update([
            'status' => 'confirmed'
        ]);

        return redirect()->route('haj.reservations.index')->with(['message' => 'تم تاكيد الحجز بنجاح']);
    }

    public function destroy($reservation_id)
    {
        $reservation = Reseervation::findOrFail($reservation_id);
        $reservation->update(['status' => 'canceled']);

        return redirect()->route('haj.reservations.index')->with(['message' => 'تم الغاء الحجز بنجاح']);
    }
}
