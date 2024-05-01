<?php

namespace Wave\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Auth;
use TCG\Voyager\Models\Permission;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('theme::tickets.index', compact('tickets'));
    }
    public function adminTickets(){
        
        $admin = auth()->user()->role_id === 1;
        if ($admin) {
            $tickets = Ticket::all();
        } else {
            $tickets = Ticket::where('id', auth()->user()->id)->get();
        }
        return view('theme::tickets.admin-tickets', compact('tickets'));
    }
    public function updateStatus(Request $request)
    {
        
        $status = $request->input('status');
        $ticketId = $request->input('ticket_id');

        
        if ($status === 'success') {
            Ticket::where('id', $ticketId)
            ->update(['status' => 'Complete']);

            return redirect()->back();
        } elseif ($status === 'under_review') {
            Ticket::where('id', $ticketId)->update(['status' => 'Under Review']);
            return redirect()->back();
       
            
        } elseif ($status === 'delete') {
            Ticket::where('id', $ticketId)->delete();
            return redirect()->back();
           
        } else {
            // Handle unknown status values
            return "Unknown status received";
        }
    }
    public function create()
    {
        return view('theme::tickets.create');
    }

    public function store(Request $request)
    {

        $ticket = new Ticket([
            'name' => $request->input('name'),
            'lname' => $request->input('lname'),
            'email'=> $request->input('email'),
            'number'=> $request->input('number'),
            'description' => $request->input('description'),
            'UsersID' => Auth::user()->id,

        ]);

        $ticket->save();

        return redirect()->back()->with('success', 'Ticket created successfully!');
    }

    public function show($id)
    {
        $ticket = Ticket::where('UsersID',$id)->get();
        return view('theme::tickets.show', compact('ticket'));
    }
}
