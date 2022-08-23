<?php

namespace App\Http\Controllers\Passenger;

use App\City;
use App\Trip;
use App\TripOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\HajCheckoutRequest;
use App\Passenger;
use App\Provider;
use App\Reseervation;
use App\Service;
use App\Setting;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
{
    public function cards()
    {
        $services = Service::all();
        return view('passengers.cards')->with('services', $services);
    }
    public function trips_car()
    {

        $tripsToYemen =  Trip::getTrips_car('dep');

        return view('passengers.card_car', [
            'tripsToYemen' => Trip::getTrips_car('sty'),
            'tripsToSa' => Trip::getTrips_car('yts'),
            'tripsBtYemen' => Trip::getTrips_car('loc'),

        ]);
    }
    public function trips_msg()
    {
        // dd(Trip::getTrips_msg('sty'));
        $tripsToYemen =  Trip::getTrips_msg('dep');

        return view('passengers.card_msg', [
            'tripsToYemen' => Trip::getTrips_msg('sty'),
            'tripsToSa' => Trip::getTrips_msg('yts'),
            'tripsBtYemen' => Trip::getTrips_msg('loc'),

        ]);
    }

    public function trips_haj()
    {
        // dd(Trip::getTrips_msg('sty'));
        $tripsToYemen =  Trip::getTrips_haj('dep');

        return view('passengers.card_haj', [
            'tripsToYemen' => Trip::getTrips_haj('sty'),
            'tripsToSa' => Trip::getTrips_haj('yts'),
            'tripsBtYemen' => Trip::getTrips_haj('loc'),

        ]);
    }
    public function index(Request $request, $slug)
    {
        // dd($request->all(), $slug);
        // $tripsToYemen =  Trip::getTrips('dep');
        // dd(Trip::getTrips('sty'));
        if ($slug == 'haj') {
            $service_id = 3;
            $trips = DB::table('trips')
                ->select(['*', 'trips.id as trip_id'])
                ->selectRaw('(select name from city where city.id = takeoff_city_id) as takeoff_city')
                ->selectRaw('(select name from city where city.id = arrival_city_id) as arrival_city')
                ->join('providers', 'providers.id', 'trips.provider_id')
                ->where('providers.service_id', $service_id)
                ->where('status', 'active')
                ->when($request->price, function ($q) use ($request) {
                    $q->where('trips.price', '<=', $request->price);
                })
                ->when($request->sub_service_id, function ($q) use ($request) {
                    $q->where('trips.sub_service_id', '=', $request->sub_service_id);
                })
                ->when($request->takeoff_city_id, function ($q) use ($request) {
                    $q->where('trips.takeoff_city_id', '=', $request->takeoff_city_id);
                })
                ->when($request->air_river, function ($q) use ($request) {
                    $q->where('trips.air_river', '=', $request->air_river);
                })
                ->get();
            $cities = City::where('country', 2)->get();
            $haj_deposit_value = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;
            $omra_deposit_value = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;
            // dd($trips);
            return view('passengers.haj', [
                'trips' =>  $trips,
                // 'cities' => $cities,
                'saudi_cities' => City::where('country', 1)->get(),
                'yamen_cities' => City::where('country', 0)->get(),
                'haj_deposit_value' => $haj_deposit_value,
                'omra_deposit_value' => $omra_deposit_value,
            ]);
        }
        return view('passengers.index', [
            'saudi_cities' => City::where('country', 1)->get(),
            'yamen_cities' => City::where('country', 0)->get(),
            'trips' => Trip::query()
                ->where(['status' => 'active', 'sub_service_id' => 5])
                // ->where('from_date', '>=', date('Y-m-d'))
                ->when($request->price, function ($q) use ($request) {
                    $q->where('trips.price', '<=', $request->price);
                })
                ->when($request->direcation, function ($q) use ($request) {
                    $q->where('trips.direcation', '=', $request->direcation);
                })
                ->when($request->takeoff_city_id, function ($q) use ($request) {
                    $q->where('trips.takeoff_city_id', '=', $request->takeoff_city_id);
                })
                ->when($request->arrival_city_id, function ($q) use ($request) {
                    $q->where('trips.arrival_city_id', '=', $request->arrival_city_id);
                })
                ->when($request->from_date, function ($q) use ($request) {
                    $q->where('trips.from_date', '=', $request->from_date);
                })
                ->paginate(10),
            // 'tripsToSa' => Trip::where(['direcation' => 'yts', 'status' => 'active', 'sub_service_id' => 5])->paginate(10),
            // 'tripsBtYemen' => Trip::where(['direcation' => 'loc', 'status' => 'active', 'sub_service_id' => 5])->paginate(10),
            'BUS_RS_DEPOSIT_VALUE' => Setting::where('key', 'BUS_RS_DEPOSIT_VALUE')->first()->value,
            'BUS_RY_DEPOSIT_VALUE' => Setting::where('key', 'BUS_RY_DEPOSIT_VALUE')->first()->value,
        ]);
    }

    public function hajDetails($id)
    {
        $trip = Trip::findOrFail($id);
        // dd($trip);
        $haj_deposit_value = Setting::where('key', 'HAJ_PROGRAM_RS_DEPOSIT')->first()->value;
        $omra_deposit_value = Setting::where('key', 'OMRA_PROGRAM_RS_DEPOSIT')->first()->value;
        return view('passengers.haj_details', [
            'trip' => $trip,
            'haj_deposit_value' => $haj_deposit_value,
            'omra_deposit_value' => $omra_deposit_value,
        ]);
    }
    public function busDetails($id)
    {
        $trip = Trip::findOrFail($id);
        // dd($trip);
        $BUS_RS_DEPOSIT_VALUE = Setting::where('key', 'BUS_RS_DEPOSIT_VALUE')->first()->value;
        $BUS_RY_DEPOSIT_VALUE = Setting::where('key', 'BUS_RY_DEPOSIT_VALUE')->first()->value;
        return view('passengers.bus_details', [
            'trip' => $trip,
            'BUS_RS_DEPOSIT_VALUE' => $BUS_RS_DEPOSIT_VALUE,
            'BUS_RY_DEPOSIT_VALUE' => $BUS_RY_DEPOSIT_VALUE,
        ]);
    }



    public function searchTrips(Request $request)
    {

        $data = $request->all();
        $allTrip = $request->has('allTrip') ? 'all' : '';

        $trips =  DB::table('trips')->select('trips.*')
            ->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')
            ->when(!empty($data['tripDate']), function ($query) use ($data) {
                return $query->where('from_date', $data['tripDate']);
            })
            ->when(!empty($data['from']), function ($query) use ($data) {
                return $query->where('from', $data['from']);
            })
            ->when(!empty($data['to']), function ($query) use ($data) {
                return $query->where('to', $data['to']);
            })
            ->when(!empty($allTrip), function ($query) use ($allTrip) {
                return $query->where('day', $allTrip);
            })
            ->paginate(10);

        //     return $trips ;
        $dataTrip['from'] = Trip::getCityName($request->from);
        $dataTrip['to'] = Trip::getCityName($request->to);
        $dataTrip['tripDate'] = $request->tripDate;
        $dataTrip['ticketNo'] = $request->ticketNo;
        $dataTrip['all'] = $allTrip;


        // $currency= Trip::getCurrency($request->from);

        return view('passengers.search', [
            'searchedTrips' => $trips,
            //     'currency' => $currency,
            'tripDetails' => $dataTrip,
        ]);
    }
    public function searchTrips_msg(Request $request)
    {

        $data = $request->all();
        $allTrip = $request->has('allTrip') ? 'all' : '';

        $trips =  DB::table('trips')->select('trips.*')
            ->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')
            ->when(!empty($data['tripDate']), function ($query) use ($data) {
                return $query->where('from_date', $data['tripDate']);
            })
            ->when(!empty($data['from']), function ($query) use ($data) {
                return $query->where('from', $data['from']);
            })
            ->when(!empty($data['to']), function ($query) use ($data) {
                return $query->where('to', $data['to']);
            })
            ->when(!empty($allTrip), function ($query) use ($allTrip) {
                return $query->where('day', $allTrip);
            })->where('msg', 1)
            ->paginate(10);

        //     return $trips ;
        $dataTrip['from'] = Trip::getCityName($request->from);
        $dataTrip['to'] = Trip::getCityName($request->to);
        $dataTrip['tripDate'] = $request->tripDate;
        $dataTrip['ticketNo'] = $request->ticketNo;
        $dataTrip['all'] = $allTrip;


        // $currency= Trip::getCurrency($request->from);

        return view('passengers.search_msg', [
            'searchedTrips' => $trips,
            //     'currency' => $currency,
            'tripDetails' => $dataTrip,
        ]);
    }
    public function searchTrips_car(Request $request)
    {

        $data = $request->all();
        $allTrip = $request->has('allTrip') ? 'all' : '';

        $trips =  DB::table('trips')->select('trips.*')
            ->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')
            ->when(!empty($data['tripDate']), function ($query) use ($data) {
                return $query->where('from_date', $data['tripDate']);
            })
            ->when(!empty($data['from']), function ($query) use ($data) {
                return $query->where('from', $data['from']);
            })
            ->when(!empty($data['to']), function ($query) use ($data) {
                return $query->where('to', $data['to']);
            })
            ->when(!empty($allTrip), function ($query) use ($allTrip) {
                return $query->where('day', $allTrip);
            })->where('trip_type', 'car')
            ->paginate(10);

        //     return $trips ;
        $dataTrip['from'] = Trip::getCityName($request->from);
        $dataTrip['to'] = Trip::getCityName($request->to);
        $dataTrip['tripDate'] = $request->tripDate;
        $dataTrip['ticketNo'] = $request->ticketNo;
        $dataTrip['all'] = $allTrip;


        // $currency= Trip::getCurrency($request->from);

        return view('passengers.search_car', [
            'searchedTrips' => $trips,
            //     'currency' => $currency,
            'tripDetails' => $dataTrip,
        ]);
    }
    public function searchTrips_haj(Request $request)
    {

        $data = $request->all();
        $allTrip = $request->has('allTrip') ? 'all' : '';

        $trips =  DB::table('trips')->select('trips.*')
            ->selectRaw('(select providers.name_company from providers where providers.id = provider_id) as provider ')
            ->when(!empty($data['tripDate']), function ($query) use ($data) {
                return $query->where('from_date', $data['tripDate']);
            })
            ->when(!empty($data['from']), function ($query) use ($data) {
                return $query->where('from', $data['from']);
            })
            ->when(!empty($data['to']), function ($query) use ($data) {
                return $query->where('to', $data['to']);
            })
            ->when(!empty($allTrip), function ($query) use ($allTrip) {
                return $query->where('day', $allTrip);
            })->where('haj', 1)
            ->paginate(10);

        //     return $trips ;
        $dataTrip['from'] = Trip::getCityName($request->from);
        $dataTrip['to'] = Trip::getCityName($request->to);
        $dataTrip['tripDate'] = $request->tripDate;
        $dataTrip['ticketNo'] = $request->ticketNo;
        $dataTrip['all'] = $allTrip;


        // $currency= Trip::getCurrency($request->from);

        return view('passengers.search_haj', [
            'searchedTrips' => $trips,
            //     'currency' => $currency,
            'tripDetails' => $dataTrip,
        ]);
    }
    public function reserveTrips($id)
    {
        $ticketCount = 1;
        $trip = Trip::getTripDetails($id);
        // ddd($trip);
        // exit();

        $totalPrice = (float)$trip->price * (float)$ticketCount;
        return view('passengers.reserveTicket', [
            'trip' => $trip,
            'ticketNo' => $ticketCount,
            'totalPrice' => $totalPrice,
            'currency' => $trip->trip_currency == 'rs' ? 'ريال سعودي' : 'ريال يمني',
            'country' => Trip::getCityCountry($trip->arrival_city_id),
        ]);
    }



    public function reserveTrips_haj($id, $ticketNo)
    {
        // var_dump("ghjk");exit();
        $trip = Trip::getTripDetails($id);

        $totalPrice = (float)$trip->price * (float)$ticketNo;
        return view('passengers.reserveTicket_haj', [
            'trip' => $trip,
            'ticketNo' => $ticketNo,
            'totalPrice' => $totalPrice,
            'currency' => Trip::getCurrency($trip->from),
            'country' => Trip::getCityCountry($trip->from),
        ]);
    }

    public function orderDetails($id)
    {
        // $order = TripOrder::findOrFail($id);
        $reservation = Reseervation::findOrFail($id);

        $trip = Trip::getTripDetails($reservation->trip_id);

        return view('passengers.ticketDetails', [
            'reservation' => $reservation,
            'trip' => $trip,
        ]);
    }
}
