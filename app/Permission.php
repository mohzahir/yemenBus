<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provider;
use App\User;
use App\Role;
use App\Marketer;

class Permission extends Model
{

public function roles() {

   return $this->belongsToMany(Role::class,'roles_permissions');
       
}





public function users() {

   return $this->belongsToMany(User::class,'user_id');
       
}
public function marketers() {

   return $this->belongsToMany(Marketer::class,'user_id');
       
}
public function providers() {

   return $this->belongsToMany(Provider::class,'user_id');
       
}
}
