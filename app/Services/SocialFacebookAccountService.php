<?php

namespace App\Services;

use App\Passenger;
use App\SocialFacebookAccount;
// use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $provider)
    {
        $account = SocialFacebookAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->passenger;
        } else {

            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);

            $passenger = Passenger::whereEmail($providerUser->getEmail())->first();

            if (!$passenger) {

                $passenger = Passenger::create([
                    'email' => $providerUser->getEmail(),
                    'name_passenger' => $providerUser->getName(),
                    'password' => md5(rand(1, 10000)),
                ]);
            }

            $account->passenger()->associate($passenger);
            $account->save();

            return $passenger;
        }
    }
}
