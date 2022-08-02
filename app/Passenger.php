<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    // protected $guard = 'passenger';

    public function routeNotificationForWhatsApp()
    {
        return $this->phone ? $this->phone : $this->y_phone;
    }
}
