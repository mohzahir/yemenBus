<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\customPasswordResetNotification;

class Admin extends Authenticatable{
 use Notifiable;
 protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    public function sendPasswordResetNotification($token){
        $this->notify(new customPasswordResetNotification($token));
    }
}
