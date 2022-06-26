<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provider;

class Bank extends Model
{
    protected $table = 'banks_info';

    protected $fillable = [
        'id','provider_id','countery','bank_account_number','IBAN','bank_name','bank_softcode'
    ];
    public function provider()
    {
        return $this->hasOne(provider::class);
    }
}
