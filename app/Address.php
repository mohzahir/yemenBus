<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provider;
use App\Marketer;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'user_id', 'countery', 'city','address_address','address_latitude','address_longitude','neigh','street'
    ];


    public function provider()
    {
        return $this->hasOne(provider::class);
    } 
    public function marketer()
    {
        return $this->hasOne(marketer::class);
    }
    
}
