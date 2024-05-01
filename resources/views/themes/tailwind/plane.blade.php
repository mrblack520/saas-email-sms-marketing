@extends('theme::layouts.dashboard')

@section('css')
    <style>
        .card-deck {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
        }
        .card-deck .card{
            position: relative;
            box-shadow: 0 3px 6px 0 #0002;
            flex-grow: 1;
        }
        .card-deck .card .badge{
            position: absolute;
            inset: 1rem 1rem auto auto;
        }
        .card-deck .card .price .tag{
            font-weight: bold;
            font-size: 2.5rem;
        }
        .card-deck .card-footer{
            padding: 0.5rem;
            text-align: center;
        }
        .card-deck .card-footer a{
            color: #fff;
            font-weight: bold
        }
    </style>
@endsection

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-rocket"></i>
        Plans
    </h1>
@endsection


@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-body position-relative">
                                <div class="price">
                                    <span class="tag">$5</span> per month
                                </div>
                                <span class="badge badge-secondary">BASIC</span>
                                <h5 class="card-title">Signup for the Basic User Plan to access all the basic features.</h5>
                                <ul class="list-unstyled">
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 1</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 2</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 3</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 4</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-primary">
                                <a href="#">switch plan</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body position-relative">
                                <div class="price">
                                    <span class="tag">$5</span> per month
                                </div>
                                <span class="badge badge-secondary">BASIC</span>
                                <h5 class="card-title">Signup for the Basic User Plan to access all the basic features.</h5>
                                <ul class="list-unstyled">
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 1</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 2</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 3</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 4</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-primary">
                                <a href="#">switch plan</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body position-relative">
                                <div class="price">
                                    <span class="tag">$5</span> per month
                                </div>
                                <span class="badge badge-secondary">BASIC</span>
                                <h5 class="card-title">Signup for the Basic User Plan to access all the basic features.</h5>
                                <ul class="list-unstyled">
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 1</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 2</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 3</li>
                                    <li><i class="voyager-check mr-2 text-success"></i> Basic Feature Example 4</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-primary">
                                <a href="#">switch plan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
