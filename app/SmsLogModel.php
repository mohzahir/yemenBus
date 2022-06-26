<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class SmsLogModel extends Model
{

    protected $table = 'sms_log';
    protected $fillable = ['body', 'numbers', 'status', 'gate_message', 'response', 'sender'];

}
