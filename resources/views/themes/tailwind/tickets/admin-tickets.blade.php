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
                <th> Name</th>
                <th>Email</th>
                <th>Description</th>
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
                <td> {{ $ticket->name }}</td>
                <td> {{ $ticket->email }}</td>
                <td class="description-cell">{{ $ticket->description }}</td>
                <td>
                    @if($ticket->status === 'Pending')
                        <span class="badge light badge-danger">{{ $ticket->status }}</span>
                    @elseif($ticket->status === 'Complete')
                        <span class="badge light badge-success">{{ $ticket->status }}</span>
                    @else
                        <span class="badge light badge-info">{{ $ticket->status }}</span>
                    @endif
                </td>
                <td>

                    <form id="statusForm" action="{{ route('ticket.status.update') }}" method="post">
                        @csrf
                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                    @if(auth()->user()->role_id == 1 )
                    <button type="submit" class="btn btn-success" name="status" value="success" @if($ticket->status === 'Complete') disabled @endif>
                        <i class="fa fa-check"></i>
                    </button>
                @endif
                        <button type="button" class="btn btn-primary btn-view" data-bs-toggle="modal" data-bs-target="#exampleModal_{{ $ticket->id }}"><i class="fa fa-eye"></i></button>  
                        <button type="submit" class="btn btn-danger" name="status" value="delete"><i class="fa fa-trash"></i></button>
                    </form>
                    
<!-- Modal -->
<div class="modal fade" id="exampleModal_{{ $ticket->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ticket Description</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         {{$ticket->description}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="{{ route('ticket.status.update') }}" method="post">
            @csrf
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            @if(auth()->user()->role_id == 1 )
            <button type="submit" name="status" value="under_review" class="btn btn-primary" @if($ticket->status === 'Complete' || $ticket->status === 'Under Review') disabled @endif>
                Under Review
            </button>
            @endif  
        </form>
        </div>
      </div>
    </div>
  </div>
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