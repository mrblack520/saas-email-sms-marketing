<?php

namespace Wave\Http\Controllers;


use App\Http\Controllers\Controller;
use wave\User;
use Wave\Country;
class ProfileController extends Controller
{
    public function index($username){
    	$user = config('wave.user_model')::where('username', '=', $username)->firstOrFail();
           	$countries = Country::all()->pluck('country_name','country_id');
    	return view('theme::profile', compact('user', 'countries'));
    }
}
