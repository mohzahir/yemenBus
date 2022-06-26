<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postpone_reservation extends Model
{

    protected $guarded = [];

    function createDate($date)
    {
        $edate = Carbon::createFromFormat('m/d/Y g:i A', $date);
        return $edate;
    }
}
