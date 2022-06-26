<?php

namespace App;
use App\Lab;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table ='city';
    protected $fillable = [
        'id','name','country'
    ];
    public $timestamps = false;
    public function labs()
    {
        return $this->hasMany('App\Lab');
    }
}
