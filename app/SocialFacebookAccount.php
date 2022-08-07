<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialFacebookAccount extends Model
{
    protected $fillable = ['passenger_id', 'provider_user_id', 'provider'];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_id', 'id');
    }
}
