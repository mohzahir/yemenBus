<?php

namespace App\Http\Controllers;

use Socialite;
use App\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    
    public function redirect($provider)
    {
     return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
       // $userSocial =   Socialite::driver($provider)->user();
       $userSocial =   Socialite::driver($provider)->stateless()->user();
       $users       =   Passenger::where(['email' => $userSocial->getEmail()])->first();
       if($users){
           Auth::guard('passenger')->login($users);
           return redirect('/passengers');
       }else{
           $user = Passenger::create([
               'name_passenger'  => $userSocial->getName(),
               'email'         => $userSocial->getEmail(),
            //   'image'         => $userSocial->getAvatar(),
               'provider_id'   => $userSocial->getId(),
               'provider'      => $provider,
           ]);        
            return redirect()->route('passengers.home');
       }
    }
    
}
