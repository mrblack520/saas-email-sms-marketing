@extends('theme::layouts.dashboard')




@section('content')
<div style="margin: 20px;" class="page-titles">
    <h1>Connected Websites</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Open Modal
    </button>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="row no-gutters">
                 
                    <!-- Left side with green background -->
                    <div class="col-md-6 bg-success text-white">
                    
                        <div class="d-flex flex-column align-items-center justify-content-end  h-100">
                            <p class="align-self-center"><i class="fa fa-check"> <span>&nbsp;&nbsp;&nbsp;</span></i>Your content goes here...</p>
                            <p class="align-self-center"><i class="fa fa-check"> <span>&nbsp;&nbsp;&nbsp;</span></i>Your content goes here...</p>
                            <p class="align-self-center"><i class="fa fa-check"> <span>&nbsp;&nbsp;&nbsp;</span></i>Your content goes here...</p>
                           
                            <form style="width: 300px;">

                                <div class="form-group mb-1">
                                    <label for="emailInput">Send by Email</label>
                                    <input type="text" class="form-control" id="emailInput" placeholder="Enter Email">
                                </div>
                            
                                <!-- Input field for number -->
                                <div class="form-group mb-1">
                                    <label for="numberInput">Send by Number</label>
                                    <input type="text" class="form-control" id="numberInput" placeholder="Enter Number">
                                </div>
                            
                                <!-- Select dropdown for reminder -->
                                <div class="form-group mb-1">
                                    
                                    <select class="form-control" id="reminderSelect">
                                        <option value="" selected disabled>Select Reminder</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                                    <!-- "Buy Later" button -->
                                <button type="button" class="btn   btn-primary btn-block">Buy Later</button>


                            </form>
                            
                            
                        </div>
                        
                    </div>

                    <!-- Right side with image -->
                    <div class="col-md-6 p-0">
                        <div class="position-relative">
                            <h1 class="position-absolute mt-4 translate-middle-x z-index-1 bg-light p-2">BUY ANOTHER TIME</h1>
                            <h3 class="position-absolute mt-5 me-3 translate-middle-x z-index-1 bg-light p-2" style="top: 46px ;">Send a reminder</h3>
                             <img src="{{ asset('Buy_Later\anton-jansson-mTIer0UVf2k-unsplash.jpg') }}" alt="Image" class="img-fluid">
                          </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="dataTable" class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    
                                    <th>
                                      Website Name 
                                    </th>
                                    <th>
                                       Owner Email
                                    </th>
                                    <th>
                                        status 
                                    </th>
                                    <th>
                                        Created At
                                    </th>
                                    
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($website as $item)
                                <tr>
                                    <td>{{ $item->Website_Name }}</td>
                                    <td>{{ $item->Email }}</td>
                                    <td>
                                        @if($item->status == 'connected')
                                            <span class="badge light badge-success">{{ $item->status }}</span>
                                        @else
                                            <span class="badge light badge-danger">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
