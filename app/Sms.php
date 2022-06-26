<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model

{
    protected $fillable = ['user_id','order_id','passenger_phone','amount','currency','subject','message'

    ];}
