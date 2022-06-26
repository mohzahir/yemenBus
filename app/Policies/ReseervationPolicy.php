<?php

namespace App\Policies;

use App\Reseervation;
use App\User;
use App\Marketer;
use App\Provider;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Auth;
class ReseervationPolicy
{
    use HandlesAuthorization;
    

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function cancel($user,Reseervation $reseervation)
    {
        
         
    if($user instanceof Marketer) {
        if ($user->code==$reseervation->code) {
           
            return true;
        }
        return false;
    }
    elseif($user instanceof Provider) {
        if ($user->id==$reseervation->provider_id) {
            return true;
        }
        return false;
    }
    
else{return Response::deny('لا يوجد لك الصلاحيه لاتمام المهمة');}
    

    }


       
        public function postpone($user,Reseervation $reservation)
    {
        
    if($user instanceof Marketer) {
        if ($user->code==$reservation->code) {
            return true;
        }
        return false;
    }
    elseif($user instanceof Provider) {
        if ($user->id==$reservation->provider_id) {
            return true;
        }
        return false;
    }
    else{return Response::deny('لا يوجد لك الصلاحيه لاتمام المهمة');}
    }


        public function update($user,Reseervation $reservation)
    {
        
    if($user instanceof Marketer) {
        if ($user->code==$reservation->code) {
            return true;
        }
        return false;
    }
    elseif($user instanceof Provider) {
        if ($user->id==$reservation->provider_id) {
            return true;
        }
        return false;
    }
    else{return Response::deny('لا يوجد لك الصلاحيه لاتمام المهمة');}
    }




 public function storetransfer($user,Reseervation $reservation)
    {
if($user instanceof Provider) {
        if ($user->id==$reservation->provider_id) {
            return true;
        }
         return Response::deny('لا يوجد لك الصلاحيه لاتمام المهمة');
    }
}



    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reseervation  $reseervation
     * @return mixed
     */
    public function view(User $user, Reseervation $reseervation)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reseervation  $reseervation
     * @return mixed
     */

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reseervation  $reseervation
     * @return mixed
     */
    public function delete(User $user, Reseervation $reseervation)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reseervation  $reseervation
     * @return mixed
     */
    public function restore(User $user, Reseervation $reseervation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Reseervation  $reseervation
     * @return mixed
     */
    public function forceDelete(User $user, Reseervation $reseervation)
    {
        //
    }
}
