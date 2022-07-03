<?php

namespace App\Http\Controllers\Provider;

// use App\Http\Controllers\Controller;
use App\Provider;
use App\Reseervation;
use App\Setting;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HajReservationController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        // $providers_ids = Provider::where('service_id', '3')->pluck('id');
        $provider_id = Auth::guard('provider')->user()->id;
        $trips_ids = Trip::where('provider_id', $provider_id)->pluck('id');
        $reservations = Reseervation::whereIn('trip_id', $trips_ids)->paginate('10');
        // dd($providers_ids, $trips_ids, $reservations);
        return view('providers.haj-reservation.index', compact('reservations'));
    }

    public function show($reservation)
    {
        $reservation = Reseervation::findOrFail($reservation);
        // dd($reservation);

        return view('providers.haj-reservation.show', ['reservation' => $reservation]);
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