<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'descr',
        'img',
        'slug',
        'updated_at',
        'created_at'
    ];

    public function sub_services()
    {
        return $this->belongsToMany(SubService::class, 'services_sub_services', 'service_id', 'sub_service_id');
    }
}
