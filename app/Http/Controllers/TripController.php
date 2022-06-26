<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTripRequest;
use Illuminate\Http\Request;
use App\Provider;
use App\Service;
use App\SubService;
use App\Trip;
use Auth;
use Carbon\Carbon;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('provider')->user()->id;
        $trips = Trip::where('provider_id', $id)->orderby('created_at', 'desc')->paginate(10);
        return view('providers.trip.index')->with('trips', $trips);
    }
    public function haj()
    {
        $id = Auth::guard('provider')->user()->id;
        $trips = Trip::where('provider_id', $id)->where('haj', 1)->orderby('created_at', 'desc')->paginate(10);
        return view('providers.trip.haj')->with('trips', $trips);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provider = auth()->guard('provider')->user();
        $service = $provider->service;
        $sub_services = $service->sub_services;

        return view('providers.trip.create', ['sub_services' => $sub_services, 'service_id' => $service->id]);
    }
    public function create_haj()
    {

        return view('providers.trip.create_haj');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTripRequest $request)
    {
        $file = null;
        if ($request->hasFile('program_details_file')) {
            // dd('d');
            $file = $request->file('program_details_file')->store('files');
        }
        //if service is haj currency is in rs
        $currency = $request->service_id == 3 ? 'rs' : ($request->direcation == 'sty' ? 'rs' : 'ry');

        $day = implode(',', $request['day']);
        $trip = new Trip();
        $trip->provider_id = $request->provider_id;
        $trip->sub_service_id = $request->sub_service_id;
        $trip->air_river = $request->air_river;
        $trip->direcation = $request->direcation;
        $trip->takeoff_city_id = $request->takeoff_city_id;
        $trip->arrival_city_id = $request->arrival_city_id;
        $trip->coming_time = $request->coming_time;
        $trip->from_date = $request->from_date;
        $trip->to_date = $request->to_date;
        $trip->leave_time = $request->leave_time;
        $trip->weight = $request->weight;
        $trip->no_ticket = $request->no_ticket;
        $trip->lines_trip = $request->lines_trip;
        $trip->note = $request->note;
        $trip->price = $request->price;
        $trip->currency = $currency;
        $trip->day = $day;
        $trip->days_count = $request->days_count;
        $trip->program_details_file = $file;
        $trip->program_details_page_content = $request->program_details_page_content;
        $trip->save();
        return redirect()->route('provider.trip.index')->with('success', 'تم  اضافة  الرحلة بنجاح');
    }
    public function store_haj(Request $request)
    {
        $user = Auth::guard('provider')->user()->car;
        // dd($user); 
        $day = implode(',', $request['day']);
        $trip = new Trip();
        $trip->direcation = $request->direcation;
        $trip->haj = $request->haj;
        $trip->provider_id = $request->provider_id;
        $trip->lines_trip = $request->lines_trip;
        $trip->from = $request->from;
        $trip->to = $request->to;
        $trip->from_date = $request->from_date;
        $trip->to_date = $request->to_date;
        $trip->coming_time = $request->coming_time;
        $trip->leave_time = $request->leave_time;
        $trip->weight = $request->weight;
        $trip->trip_no = $request->trip_no;
        $trip->no_ticket = $request->no_ticket;
        $trip->note = $request->note;
        $trip->price = $request->price;
        $trip->day = $day;


        $trip->save();

        //$trip= Trip::create($request->all());


        return redirect()->route('provider.trip.index')->with('success', 'تم  اضافة  الرحلة بنجاح');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trip = Trip::where('id', $id)->first();
        return view('providers.trip.edit')->with('trip', $trip);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trip = Trip::where('id', $id)->first();
        $trip->direcation = $request->direcation;
        $trip->takeoff_city_id = $request->takeoff_city_id;
        $trip->arrival_city_id = $request->arrival_city_id;
        $trip->lines_trip = $request->lines_trip;
        $trip->to_date = $request->to_date;
        $trip->from_date = $request->from_date;
        $trip->day = implode(',', $request['day']);

        $trip->coming_time = $request->coming_time;
        $trip->leave_time = $request->leave_time;
        $trip->weight = $request->weight;
        // $trip->trip_no = $request->trip_no;
        $trip->price = $request->price;
        $trip->currency = $request->direcation == 'yts' ? 'ry' : 'rs';
        $trip->no_ticket = $request->no_ticket;
        $trip->note = $request->note;
        $trip->save();


        return redirect(route('provider.trip.index'))->with('success', 'تم  تعديل  الرحلة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip = Trip::where('id', $id)->first();
        $trip->delete();
        return redirect(route('provider.trip.index'))->with('success', 'تم  الحذف بنجاح');
    }
    public function filter_haj(Request $request)
    {
        $id = Auth::guard('provider')->user()->id;

        $trips = Trip::where('provider_id', $id)->where('haj', 1);

        if ($request->has('day') && $request->day != '') {
            $trips->where('day', 'like', '%' . $request->day . '%')->orwhere('day', 'like', $request->day . '%')->orwhere('day', 'like', '%' . $request->day);
        }


        if ($request->has('from_date') && $request->from_date != '') {
            $trips->where('from_date', $request->from_date);
        }



        if ($request->has('from') && $request->from != '') {
            $trips->where('from', $request->from);
        }

        if ($request->has('to') && $request->to != '') {
            $trips->where('to', $request->to);
        }

        $trips = $trips->orderby('id', 'DESC')->get();
        $output[] = "";

        if ($trips) {


            foreach ($trips as $key => $trip) {
                $d = $trip->dayTr();
                //dd($d);
                /*
*/

                $output[] = '<tr>' .
                    '<td>' . $trip->price . '</td>' .

                    '<td>' . $trip->from . '</td>' .
                    '<td>' . $trip->to . '</td>' .
                    '<td>' . $trip->lines_trip . '</td>' .




                    '<td>' . '' . '</td>' .
                    '<td>' . $trip->from_date . '</td>' .
                    '<td>' . $trip->to_date . '</td>' .
                    '<td>' . $trip->no_ticket . '</td>' .

                    '<td>' . $trip->coming_time . '</td>' .

                    '<td>' . $trip->leave_time . '</td>' .
                    '<td>' . $trip->weight . '</td>' .

                    '<td>' . $trip->trip_no . '</td>' .

                    '<td><a class="btn btn-sm btn-success" href="trip/edit/' . $trip->id . '" style="margin-bottom: 10px">تعديل</a>
                    <a class="btn btn-sm btn-danger" href="trip/delete/' . $trip->id . '">الغاء </a>
                    </td>' .

                    '</tr>';
            }
            return Response($output);
        }
    }





    public function filter(Request $request)
    {
        $id = Auth::guard('provider')->user()->id;

        $trips = Trip::where('provider_id', $id)->where('haj', '!=', 1);

        if ($request->has('day') && $request->day != '') {
            $trips->where('day', 'like', '%' . $request->day . '%')->orwhere('day', 'like', $request->day . '%')->orwhere('day', 'like', '%' . $request->day);
        }


        if ($request->has('from_date') && $request->from_date != '') {
            $trips->where('from_date', $request->from_date);
        }



        if ($request->has('from') && $request->from != '') {
            $trips->where('from', $request->from);
        }

        if ($request->has('to') && $request->to != '') {
            $trips->where('to', $request->to);
        }

        $trips = $trips->orderby('id', 'DESC')->get();
        $output[] = "";

        if ($trips) {


            foreach ($trips as $key => $trip) {
                $d = $trip->dayTr();
                //dd($d);
                /*
*/

                $output[] = '<tr>' .
                    '<td>' . $trip->price . '</td>' .

                    '<td>' . $trip->from . '</td>' .
                    '<td>' . $trip->to . '</td>' .
                    '<td>' . $trip->lines_trip . '</td>' .




                    '<td>' . '' . '</td>' .
                    '<td>' . $trip->from_date . '</td>' .
                    '<td>' . $trip->to_date . '</td>' .
                    '<td>' . $trip->no_ticket . '</td>' .

                    '<td>' . $trip->coming_time . '</td>' .

                    '<td>' . $trip->leave_time . '</td>' .
                    '<td>' . $trip->weight . '</td>' .

                    '<td>' . $trip->trip_no . '</td>' .

                    '<td><a class="btn btn-sm btn-success" href="trip/edit/' . $trip->id . '" style="margin-bottom: 10px">تعديل</a>
                    <a class="btn btn-sm btn-danger" href="trip/delete/' . $trip->id . '">الغاء </a>
                    </td>' .

                    '</tr>';
            }
            return Response($output);
        }
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
}
