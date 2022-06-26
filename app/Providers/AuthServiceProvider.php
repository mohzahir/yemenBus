<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ReseervationPolicy;
use App\Policies\UserPolicy;
use App\Policies\RechargePolicy;

use App\User;
use App\Recharge;
use App\Reseervation;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
                Reseervation::class => ReseervationPolicy::class,
                User::class => UserPolicy::class,
                Recharge::class => RechargePolicy::class,

        ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
