<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubService extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'sub_services';

    public function services()
    {
        return $this->belongsToMany(Service::class, 'services_sub_services', 'sub_service_id', 'service_id');
    }
}
