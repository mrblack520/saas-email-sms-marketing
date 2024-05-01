<?php

namespace App\Http\Controllers;
use Wave\User;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            //create a user using socialite driver google
            $user = Socialite::driver('google')->user();

            // if the user exists, use that user and login
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){

                //if the user exists, login and show dashboard
                Auth::login($finduser);
                return redirect('/');
            }else{
                //user is not yet created, so create first
                $name = $user->name;
                $i = 1;
                while (User::where('name', $name)->exists()) {
                    $name = $user->name . $i;
                    $i++;
                }
                $newUser = User::create([
                    'name' => $name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'role_id'=>2,
                    'password' => encrypt('')
                ]);

                //login as the new user
                Auth::login($newUser);
                // go to the dashboard
                return redirect('/');
            }
            //catch exceptions
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
