<?php

namespace App\Http\Controllers;

use Socialite;
use Auth;
use App\User;
use App\Human;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        
        $authUser = $this->findOrCreateUser($user, 'google');
        Auth::login($authUser, true);
        return redirect('/');
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        
        $authUser = $this->findOrCreateUser($user, 'facebook');
        $human    = $this->findOrCreateHuman($authUser);
        Auth::login($authUser, true);

        if (!$authUser->stripe_id) {
            return redirect('/choose-plan');
        }

        return redirect('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }

    public function findOrCreateHuman($user)
    {
        $human = $user->human;

        if (isset($human)) {
            return $human; 
        }
        
        $name = explode(' ', $user->name);
        $human = new Human;

        $human->type           = 'standard';
        $human->classification = 0;
        $human->first_name     = reset($name);
        $human->last_name      = end($name);
        $human->email          = $user->email;
        $human->user_id = $user->id;

        $human->save();
        return $human;
    }
}