@extends('theme::layouts.dashboard')

@section('content')

    <div class=" d-flex justify-content-center align-items-center vh-100">
	<div class="row">

        <div class="col-xl-5">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Regular email</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Use our email builder to launch a campaign in minutes.</p>
                </div>
                <div class="card-footer">
                    <form action="{{ route('edit_campaign') }}" method="POST">
                        @csrf
                        <input type="hidden" name="campaign_type" value="Regular email">
                        <button type="submit" class="btn btn-primary">Start Designing</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">Regular SMS</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Use our SMS builder to launch a campaign in minutes.</p>
                </div>
                <div class="card-footer">
                    <form action="{{ route('edit_campaign') }}" method="post">
                        @csrf
                        <input type="hidden" name="campaign_type" value="Regular SMS">
                        <button type="submit" class="btn btn-primary">Start Designing</button>
                    </form>
                </div>
            </div>
        </div>
        </div>






@endsection
