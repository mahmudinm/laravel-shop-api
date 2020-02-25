<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\User;

class SocialController extends Controller
{
    /**
     * Redirect Login Social 
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);

        return response()->json($user);
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        else{
            // $data = new User::create([
            //     'name'     => $user->name,
            //     'email'    => !empty($user->email)? $user->email : '' ,
            //     'provider' => $provider,
            //     'provider_id' => $user->id
            // ]);
            $data = new User;
            $data->name = $user->name;
            $data->email = !empty($user->email)? $user->email : '';
            // $data->password = null;
            $data->provider = $provider;
            $data->provider_id = $user->id;
            $data->save();

            return $data;
        }        
    }    

    
}
