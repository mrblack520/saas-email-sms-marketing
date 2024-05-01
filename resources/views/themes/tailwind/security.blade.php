@extends('theme::layouts.dashboard')


@section('page_header')
    <h1 class="page-title">
        <i class="voyager-lock"></i>
        Security
    </h1>
@endsection


@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add" action="http://localhost:8000/admin/menus" method="POST">
                        @csrf

                        <div class="panel-body">
                            <div class="form-group col-md-12 ">
                                <label class="control-label" for="current_password">Current password</label>
                                <input required type="text" class="form-control" id="current_password"
                                    name="current_password" placeholder="Current password"value="">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label class="control-label" for="new_password">New password</label>
                                <input required type="text" class="form-control" id="new_password"
                                    name="new_password" placeholder="New password"value="">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label class="control-label" for="confirm_password">Confirm password</label>
                                <input required type="text" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="New password"value="">
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
@endsection
