{{-- @extends('theme::layouts.dashboard')


@section('page_header')
    <h1 class="page-title">
        <i class="voyager-person"></i>
        Profile
    </h1>
@endsection


@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add" action="http://localhost:8000/admin/menus" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="panel-body">
                            <div class="form-group  col-md-6 ">
                                <label class="control-label"  for="name">First name</label>
                                <input required type="text" value="" class="form-control" name="fname"
                                    placeholder="first name"value="">
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="name">Last name</label>
                                <input required type="text" class="form-control" name="lname"
                                    placeholder="last name"value="">
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="name">Company name</label>
                                <input type="text" class="form-control" name="company"
                                    placeholder="company name"value="">
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="name">Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="phone"value="">
                            </div>
                            <div class="form-group  col-md-12 ">
                                <label class="control-label" for="name">Address</label>
                                <input type="text" class="form-control" name="phone" placeholder="address"value="">
                            </div>
                            <div class="form-group  col-md-3 ">
                                <label class="control-label" for="country">Country</label>
                                <select class="form-control" id="country">
                                    <option>Select country</option>
                                    <option>USA</option>
                                    <option>UK</option>
                                    <option>Canada</option>
                                    <option>Germany</option>
                                    <option>UAE</option>
                                </select>
                            </div>
							<div class="form-group  col-md-3 ">
                                <label class="control-label" for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="state" value="">
                            </div>
							<div class="form-group  col-md-3 ">
                                <label class="control-label" for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="city" value="">
                            </div>
							<div class="form-group  col-md-3 ">
                                <label class="control-label" for="zip">Zip code</label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="zip code" value="">
                            </div>

                        </div>

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Save</button>
                        </div>
                    </form>

                    <div style="display:none">
                        <input type="hidden" id="upload_url" value="http://localhost:8000/admin/upload">
                        <input type="hidden" id="upload_type_slug" value="menus">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
@extends('theme::layouts.app')


@section('content')

	<div class="flex flex-col px-8 mx-auto my-6 xl:px-5 lg:flex-row max-w-7xl">

		<div class="flex flex-col items-center justify-center w-full px-10 py-16 mb-8 mr-6 bg-white border rounded-lg lg:mb-0 lg:flex-1 lg:w-1/3 border-gray-150">
			<img src="{{ Voyager::image($user->avatar) }}" class="w-24 h-24 border-4 border-gray-200 rounded-full">
			<h2 class="mt-8 text-2xl font-bold">{{ $user->name }}</h2>
			<p class="my-1 font-medium text-wave-blue">{{ '@' . $user->username }}</p>
			<div class="px-3 py-1 my-2 text-xs font-medium text-white text-gray-600 bg-gray-200 rounded">{{ $user->role->display_name }}</div>
			<p class="max-w-lg mx-auto mt-3 text-base text-center text-gray-500">{{ $user->profile('about') }}</p>
		</div>

		<div class="flex flex-col w-full p-10 overflow-hidden bg-white border rounded-lg lg:w-2/3 border-gray-150 lg:flex-2">
			<form action="{{ route('wave.settings.profile.put') }}" method="POST" enctype="multipart/form-data">
                <div class="relative flex flex-col px-10 py-8 lg:flex-row">
                    <div class="flex justify-start w-full mb-8 lg:w-3/12 xl:w-1/5 lg:m-b0">
                        <div class="relative w-32 h-32 cursor-pointer group">
                            <img id="preview" src="{{ Voyager::image(auth()->user()->avatar) . '?' . time() }}" class="w-32 h-32 rounded-full ">
                            <div class="absolute inset-0 w-full h-full">
                                <input type="file" id="upload" class="absolute inset-0 z-20 w-full h-full opacity-0 cursor-pointer group">
                                <input type="hidden" id="uploadBase64" name="avatar">
                                <button class="absolute bottom-0 z-10 flex items-center justify-center w-10 h-10 mb-2 -ml-5 bg-black bg-opacity-75 rounded-full opacity-75 group-hover:opacity-100 left-1/2">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-9/12 xl:w-4/5">
                        <div>
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">Name</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="name" type="text" name="name" placeholder="Name" value="{{ Auth::user()->name }}" required class="w-full form-input">
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Email Address</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="email" type="text" name="email" placeholder="Email Address" value="{{ Auth::user()->email }}" required class="w-full form-input">
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="about" class="block text-sm font-medium leading-5 text-gray-700">About</label>
                            <div class="mt-1 rounded-md">
                                {!! profile_field('text_area', 'about') !!}
                            </div>
                        </div>

                        {{-- <div class="flex justify-end w-full">
                            <button class="flex self-end justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700" dusk="update-profile-button">Save</button>
                        </div> --}}
                    </div>
                </div>


		</div>


	</div>
    <div class="flex justify-center">
        <div class="flex flex-col w-full p-10 overflow-hidden bg-white border rounded-lg lg:w-2/3 border-gray-150 lg:flex-2">

                <div class="panel-body">
                    <div class="form-group  col-md-6 ">
                        <label class="control-label"  for="name">First name</label>
                        <input required type="text" value="{{ Auth::user()->fname }}" class="form-control" name="fname"
                            placeholder="first name"value="">
                    </div>
                    <div class="form-group  col-md-6 ">
                        <label class="control-label" for="name">Last name</label>
                        <input required type="text" value="{{ Auth::user()->lname }}" class="form-control" name="lname"
                            placeholder="last name"value="">
                    </div>
                    <div class="form-group  col-md-6 ">
                        <label class="control-label"  for="name">Company name</label>
                        <input type="text" value="{{ Auth::user()->company }}" class="form-control" name="company"
                            placeholder="company name"value="">
                    </div>
                    <div class="form-group  col-md-6 ">
                        <label class="control-label" for="name">Phone</label>
                        <input type="text" class="form-control"  value="{{ Auth::user()->phone }}" name="phone" placeholder="phone"value="">
                    </div>
                    <div class="form-group  col-md-12 ">
                        <label class="control-label"  for="name">Address</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->address }}" name="address" placeholder="address"value="">
                    </div>
                    <div class="form-group  col-md-3 ">
                        <label class="control-label" for="country">Country</label>
                        <select name="country_id" id="country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                             </select>    
                    </div>
                    <div class="form-group  col-md-3 ">
                        {{-- <label class="control-label" for="state">State</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->state }}" id="state" name="state" placeholder="state" value=""> --}}
                        <label class="control-label" for="state">Select your State</label>
                        <select name="state_id" id="state" class="form-control">
                            <option value="">Select State</option>   
                        </select> 
                    </div>
                    <div class="form-group  col-md-3 ">
                        {{-- <label class="control-label" for="city">City</label> --}}
                        {{-- <input type="text" class="form-control" id="city" value="{{ Auth::user()->city }}" name="city" placeholder="city" value=""> --}}
                        <label class="control-label" for="city">Select your City</label>
                       <select name="city_id" id="city" class="form-control">
                <option value="">Select City</option>   
                </select>   
                    </div>
                    <div class="form-group  col-md-3 ">
                        <label class="control-label" for="zip">Zip code</label>
                        <input type="text" class="form-control" id="zip" value="{{ Auth::user()->zip }}" name="zip" placeholder="zip code" value="">
                    </div>

                </div>

                <div class="flex justify-end w-full">
                    <button class="flex self-end justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700" dusk="update-profile-button">Save</button>
                </div>

                {{ csrf_field() }}



            </form>
		</div>


	</div>
@endsection
