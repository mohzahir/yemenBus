<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    protected $fillable = [
        'id','amount','notes','transfer_img','marketer_id','currecny','created_at','updated_at'];

        protected $dates = ['created_at','updated_at'];

    



}
