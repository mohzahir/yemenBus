<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Address;

class Marketer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'marketer';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'balance_rs', 'balance_ry', 'state', 'provider_id', 'currency', 'max_rs', 'max_ry', 'tip_rs', 'tip_ry', 'address_address', 'address_latitude', 'address_longitude', 'code'
    ];
    protected $guarded = ['id'];

    protected $hidden = ['remember_token', 'password'];

    public function getAuthPassword()
    {
        return $this->password;
    }


    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
