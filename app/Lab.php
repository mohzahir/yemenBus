<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\City;
class Lab extends Authenticatable
{
    use Notifiable;

   protected $guard ='lab';
   public $table ='labs';
    protected $fillable = [
        'id','name','city_id','phone','position','w_clock','password','priority'
    ];
   
 protected $hidden = [
        'password', 'remember_token',
    ];
    public $timestamps = false;
    
    public function city()
    {
        return $this->belongsTo('App\City');
    }
   
   
    
}
