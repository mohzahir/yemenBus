<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTripRequest;
use Illuminate\Http\Request;
use App\Trip;
use App\Provider;
use App\Service;
use App\SubService;
use DB;
use Carbon\Carbon;

class AdminTripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $trips = Trip::orderBy('id', 'DESC')->paginate(10);


        return view('dashboard.providers.trips')->with('trips', $trips);
    }

    /**
     * Show the form for creating a new trip.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();

        return view('dashboard.providers.createTrip')->with(['services' => $services]);
    }

    public function activate($id)
    {
        $trip = Trip::findOrFail($id);
        $status = ($trip->status == 'active' ? 'inactive' : 'active');
        // dd($status);
        $trip->update([
            'status' => $status
        ]);

        return redirect()->route('dashboard.providers.trips')->with(['success' => 'تم تغيير الحاله بنجاح']);
    }

    public function getServiceProviders(Request $request)
    {
        $providers =  Provider::where('service_id', $request->id)->get();
        return response()->json($providers);
    }
    public function getServiceSubServices(Request $request)
    {
        $provider =  Provider::findOrFail($request->provider_id);
        $service = $provider->service;
        $sub_services = $service->sub_services;
        // dd($sub_services);
        return response()->json($sub_services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTripRequest $request)
    {
        // dd($request);
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
        return redirect()->route('dashboard.providers.trips')->with('success', 'تم  اضافة  الرحلة بنجاح');
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
        return view('dashboard.providers.editTrip')->with('trip', $trip);
    }

    /* *
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

        return redirect(route('dashboard.providers.trips'))->with('success', 'تم  تعديل  الرحلة بنجاح');
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
        return redirect(route('dashboard.providers.trips'))->with('success', 'تم  الحذف بنجاح');
    }
    public function filter(Request $request)
    {




        $trips = DB::table('trips');

        if ($request->has('day') && $request->day != '') {
            $trips->where('day', 'like', '%' . $request->day . '%');
        }
        if ($request->has('date') && $request->date != '') {
            $trips->where('from_date', $request->date);
        }



        if ($request->has('from') && $request->from != '') {
            $trips->where('from', $request->from);
        }

        if ($request->has('to') && $request->to != '') {
            $trips->where('to', $request->to);
        }
        if ($request->has('provider_id') && $request->provider_id != '') {
            $trips->where('provider_id', $request->provider_id);
        }

        $trips = $trips->orderBy('id', 'DESC')->get();
        $output[] = "";
        if ($trips) {



            foreach ($trips as $trip) {

                $provider = Provider::where('id', $trip->provider_id)->first();

                $output[] = '<tr>' .
                    '<td>' . $provider->name_company . '</td>' .

                    '<td>' . $trip->price . '</td>' .
                    '<td>' . $trip->from . '</td>' .
                    '<td>' . $trip->to . '</td>' .
                    '<td>' . $trip->lines_trip . '</td>' .
                    '<td>' . $trip->day . '</td>' .
                    '<td>' . $trip->from_date . '</td>' .
                    '<td>' . $trip->to_date . '</td>' .
                    '<td>' . $trip->no_ticket . '</td>' .

                    '<td>' . $trip->coming_time . '</td>' .
                    '<td>' . $trip->leave_time . '</td>' .
                    '<td>' . $trip->weight . '</td>' .
                    '<td>' . $trip->trip_no . '</td>' .

                    '<td style="display:inline;width:100%"><a class="btn btn-sm btn-warning" href="trip/edit/' . $trip->id . '" style="margin-bottom: 10px">تعديل</a>
                    <a class="btn btn-sm btn-danger" href="trip/destroy/' . $trip->id . '">الغاء </a>
                    </td>' .

                    '</tr>';
            }


            return Response($output);
        }

        //return Response(['msg'=>'لا يوجد']); 


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
