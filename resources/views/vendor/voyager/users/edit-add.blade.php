@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ (isset($dataTypeContent->id)) ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) : route('voyager.'.$dataType->slug.'.store') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                    {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="{{ __('First name') }}"
                                       value="@if(isset($dataTypeContent->fname)){{ $dataTypeContent->fname }}@endif">
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="name">{{ __('Company') }}</label>
                                    <input type="text" class="form-control" id="company" name="company" placeholder="{{ __('Company') }}"
                                           value="@if(isset($dataTypeContent->company)){{ $dataTypeContent->company }}@endif">
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="name">{{ __('Phone') }}</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ __('Phone') }}"
                                               value="@if(isset($dataTypeContent->phone)){{ $dataTypeContent->phone }}@endif">
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="name">{{ __('Country') }}</label>
                                            <input type="text" class="form-control" id="country" name="country" placeholder="{{ __('country') }}"
                                                   value="@if(isset($dataTypeContent->country)){{ $dataTypeContent->country }}@endif">
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="name">{{ __('State') }}</label>
                                                <input type="text" class="form-control" id="state" name="state" placeholder="{{ __('state') }}"
                                                       value="@if(isset($dataTypeContent->state)){{ $dataTypeContent->state }}@endif">
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="name">{{ __('City') }}</label>
                                                    <input type="text" class="form-control" id="city" name="city" placeholder="{{ __('city') }}"
                                                           value="@if(isset($dataTypeContent->city)){{ $dataTypeContent->city }}@endif">
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('Zip') }}</label>
                                                        <input type="text" class="form-control" id="zip" name="zip" placeholder="{{ __('zip') }}"
                                                               value="@if(isset($dataTypeContent->zip)){{ $dataTypeContent->zip }}@endif">
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="name">{{ __('Address') }}</label>
                                                            <input type="text" class="form-control" id="address" name="address" placeholder="{{ __('address') }}"
                                                                   value="@if(isset($dataTypeContent->address)){{ $dataTypeContent->address }}@endif">
                                                        </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="name">{{ __('Last Name') }}</label>
                                        <input type="text" class="form-control" id="lname" name="lname" placeholder="{{ __('Last Name') }}"
                                               value="@if(isset($dataTypeContent->lname)){{ $dataTypeContent->lname }}@endif">
                                    </div>
                            <div class="form-group">
                                <label for="name">{{ __('voyager::generic.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('voyager::generic.name') }}"
                                       value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('voyager::generic.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('voyager::generic.email') }}"
                                       value="@if(isset($dataTypeContent->email)){{ $dataTypeContent->email }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="username" class="form-control" id="username" name="username" placeholder="Username"
                                       value="@if(isset($dataTypeContent->username)){{ $dataTypeContent->username }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('voyager::generic.password') }}</label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>{{ __('voyager::profile.password_hint') }}</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password">
                            </div>


                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                    $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                    if(is_string($row->details)){
                                        $options = json_decode($row->details);
                                    } else {
                                        $options = $row->details;
                                    }
                                @endphp

                                <div class="form-group">
                                    <label for="role_id">Primary Role</label>
                                    @php $roles = TCG\Voyager\Models\Role::all(); @endphp
                                    <select name="role_id" id="role_id" class="select2" placeholder="">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($role->id == $dataTypeContent->role_id) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>
                                    @php
                                        $row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();
                                        if(is_string($row->details)){
                                            $options = json_decode($row->details);
                                        } else {
                                            $options = $row->details;
                                        }
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" name="avatar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save">
                {{ __('voyager::generic.save') }}
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@stop
