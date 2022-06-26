<?php

namespace App;

use App\TripOrderPassenger;
use Illuminate\Database\Eloquent\Model;

class TripOrder extends Model
{
    protected $fillable = ['passenger_id','trip_id','y_phone','s_phone','email', 'status','price',
'total','remain', 'payment_method','notes','payment_type','ticket_no'];
    protected $table  = 'trip_orders';

    public function passengers()
    {
        return $this->hasMany(TripOrderPassenger::class,'trip_ordrer_id', 'id');
    }

    public function trips()
    {
        return $this->belongsTo(Trip::class,'trip_id','id');    
    }
}
