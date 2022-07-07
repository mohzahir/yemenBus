<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use App\Provider;
use App\Reseervation;
use App\Setting;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HajReservationController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $providers_ids = Provider::where('service_id', '3')->pluck('id');
        $trips_ids = Trip::whereIn('provider_id', $providers_ids)->pluck('id');
        $reservations = Reseervation::whereIn('trip_id', $trips_ids)->paginate('10');
        // dd($providers_ids, $trips_ids, $reservations);
        return view('dashboard.haj-reservation.index', compact('reservations'));
    }

    public function show($reservation)
    {
        $reservation = Reseervation::findOrFail($reservation);
        // dd($reservation);

        return view('dashboard.haj-reservation.show', ['reservation' => $reservation]);
    }
    public function passengerInfo($reservation)
    {
        $reservation = Reseervation::findOrFail($reservation);
        // dd($reservation);

        return view('dashboard.haj-reservation.passenger-info', ['reservation' => $reservation]);
    }

    public function storePassengerInfo(Request $request, $reservation_id)
    {
        // dd($request->all());
        $reservation = Reseervation::findOrFail($reservation_id);
        $reservation->update([
            'haj_passenger_external_ticket_number' => $request->haj_passenger_external_ticket_number,
            'haj_passenger_hotel_details' => $request->haj_passenger_hotel_details,
            'haj_passenger_sickness_status' => $request->haj_passenger_sickness_status,
        ]);
        return redirect()->route('haj.reservations.index')->with(['success' => 'تم تعديل البيانات بنجاح']);
    }



    public function create()
    {
        // 

    }

    public function store()
    {
        //
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
