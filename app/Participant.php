<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function getPhoneCountryCodeAttribute() {
        return substr($this->phone, 0, 3);
    }
}
