<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reseervation extends Model
{
    protected $guarded = [];
    protected $table  = 'reseervations';
    protected $fillable = [
        'id',
        'trip_id',
        'marketer_id',
        'main_passenger_id',
        'ticket_no',
        'payment_method',
        'payment_type',
        'payment_time',
        'total_price',
        'paid',
        'currency',
        'payment_image',
        'status',
        'note',
        'haj_passenger_external_ticket_number',
        'haj_passenger_hotel_details',
        'haj_passenger_sickness_status',
        'order_id',
        'demand_id',
        'order_url',
        'passenger_phone_yem',
        'passenger_name',
        'passenger_phone',
        'provider_id',
        'whatsup',
        'amount',
        'amount_deposit',
        'amount_type',
        'day',
        'code',
        'from_city',
        'to_city',
        'date'
    ];

    protected  $dates = ['date'];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'main_passenger_id');
    }
    public function marketer()
    {
        return $this->belongsTo(Marketer::class, 'marketer_id');
    }


    public static function getFullReservationsDetails($id = null)
    {
        return DB::table('trips')
            ->select(['reseervations.*', 'passengers.phone', 'passengers.y_phone', 'passengers.name_passenger', 'trips.from_date', 'trips.to_date', 'trips.day', 'trips.provider_id', 'marketers.name as marketer_name'])
            ->selectRaw('(select city.name from city where city.id = trips.takeoff_city_id) as takeoff_city ')
            ->selectRaw('(select city.name from city where city.id = trips.arrival_city_id) as arrival_city ')
            ->join('reseervations', 'reseervations.trip_id', '=', 'trips.id', 'inner')
            ->join('passengers', 'passengers.id', '=', 'reseervations.main_passenger_id')
            ->join('marketers', 'marketers.id', '=', 'reseervations.marketer_id', 'left')
            ->when($id, function ($q) use ($id) {
                $q->where('trips.provider_id', $id);
            })
            ->paginate('10');
    }
}
