<?php

namespace App\Policies;

use App\Recharge;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RechargePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function chargeForm($user)
    {
    
    if($user instanceof User){ 
                return true;}
        else{return false;}
        
    
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Recharge  $recharge
     * @return mixed
     */
    public function view(User $user, Recharge $recharge)
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
     * @param  \App\Recharge  $recharge
     * @return mixed
     */
    public function update(User $user, Recharge $recharge)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Recharge  $recharge
     * @return mixed
     */
    public function delete(User $user, Recharge $recharge)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Recharge  $recharge
     * @return mixed
     */
    public function restore(User $user, Recharge $recharge)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Recharge  $recharge
     * @return mixed
     */
    public function forceDelete(User $user, Recharge $recharge)
    {
        //
    }
}
