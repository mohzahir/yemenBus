<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Reseervation;
use App\Trip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlobalSharedController extends Controller
{
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
            $provider_ids = Provider::where('service_id', 1)->pluck('id');
            $trips = Trip::whereIn('provider_id', $provider_ids)->where(['status' => 'active'])->get();
        } else {
            // haj
            $provider_ids = Provider::where('service_id', 3)->pluck('id');
            $trips = Trip::whereIn('provider_id', $provider_ids)->where(['status' => 'active'])->get();
        }

        return view('dashboard.reservation.transfer', [
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

                Reseervation::create([
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

                // dd($request);
            } catch (\Throwable $th) {

                throw $th;
            }
        });
        return redirect()->back()->with(['success' => 'تم نقل الحجز بنجاح يمكنك مراجعه الحجوزات']);
    }

    public function getTripData(Request $request)
    {
        $trip =  Trip::with(['takeoff_city', 'arrival_city', 'provider'])->findOrFail($request->id);
        // dd($sub_services);
        return response()->json($trip);
    }
}
