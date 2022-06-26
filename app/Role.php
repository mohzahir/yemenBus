<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provider;
use App\User;
use App\Permission;
use App\Marketer;

class Role extends Model
{
       public function permissions() {

   return $this->belongsToMany(Permission::class,'roles_permissions');
       
}


public function users() {

   return $this->belongsToMany(User::class,'users_roles');
       
}
public function marketers() {

   return $this->belongsToMany(Marketer::class,'users_roles');
       
}
public function providers() {

   return $this->belongsToMany(Provider::class,'users_roles');
       
}

}
