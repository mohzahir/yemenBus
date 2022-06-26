<?php

namespace App;

use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Address;

class Provider extends Authenticatable
{
    use Notifiable;


    protected $guard = 'provider';

    protected $fillable = [
        'id', 'name', 'service_id', 'email', 'password', 'phone', 'name_company', 'city'
    ];
    protected $guarded = ['id'];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'provider_id');
    }
}
