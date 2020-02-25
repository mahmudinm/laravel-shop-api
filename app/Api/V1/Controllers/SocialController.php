<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
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
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);

        return response()->json($authUser);
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first():

        if($authUser) {
            return $authUser;
        } else {
            $data = User::create([
                'name' => $user->name,
                'email' => !empty($user->email) ? $user->email : '',
                'provider' => $provider,
                'provider_id' => $user->id,
            ]);
        }
    }    

    
}
