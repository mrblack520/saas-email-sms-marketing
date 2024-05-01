@extends('theme::layouts.dashboard')




@section('content')
<style>
     .description-cell {
        max-width: 200px; 
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<div class="page-titles">
    <h1>Tickets</h1>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="display table ">
        <thead >
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Dubscription Date</th>
                <th>plan</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
        @php
        $serialNumber = 1;
        @endphp
        @foreach ($tickets as $ticket)
        <tbody>
            <tr>
                <td>{{ $serialNumber++ }}</td>
              
                <td> {{ $ticket->user_email }}</td>
                <td class="description-cell">  @if($tickets)
                  {{ Carbon\Carbon::parse($ticket->created_at)->toFormattedDateString() }}
              @endif</td>
              <td>{{ $ticket->plan_name }}</td>
                <td>
                    @if($ticket->status === 'succeeded')
                    <span class="badge light badge-success">{{ $ticket->status }}</span>
                       
                    @else
                    <span class="badge light badge-danger">{{ $ticket->status }}</span>
                   
                    @endif
                </td>
                <td>
                  
                    
                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                    <a href="{{ asset('storage/'.$ticket->invoice_pdf_path ) }}" target="_blank" class="btn btn-primary btn-view">
                      <i class="fa fa-eye"></i>
                  </a>
                       
                </td>
  
                    

            </tr>

        </tbody>
        @endforeach
    </table>
</div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewModalLabel">Ticket escription</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Display ticket details here -->
          <div id="ticketDetails"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  

@endsection