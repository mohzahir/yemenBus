<?php

namespace App;

use App\TripOrder;
use Illuminate\Database\Eloquent\Model;

class TripOrderPassenger extends Model
{
    //
    protected $guarded = [];
    protected $table  = 'trip_order_passengers';

    public function triporder()
    {
        return $this->belongsTo(TripOrder::class);    
    }
    
}
