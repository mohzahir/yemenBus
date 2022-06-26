<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cancel_reservation extends Model
{
    protected $guarded = [];
 protected $fillable = [
        'id','order_id','order_url','passenger_phone','provider_id','amount','amount_deposit','amount_type','code','whatsup','currency','notes'




    ];
    function createDate($date)
    {
        $edate = Carbon::createFromFormat('m/d/Y g:i A', $date);
        return $edate;
    }
}
