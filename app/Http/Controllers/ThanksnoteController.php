<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thanksnote;
use App\Models\Reference;
use App\Models\Members;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThanksnoteController extends Controller
{
    // Show the Raise Thanksnote form
    public function create()
    {
        $userId = Auth::id();
    
        // Fetch members excluding the logged-in user and only those with payment = 1
        $thanksnoteMembers = Members::where('id', '!=', $userId)
                                    ->where('payment', 1) // Only show paid members
                                    ->orderBy('first_name', 'asc')
                                    ->get();
    
        // Fetch references given by the logged-in user
        $references = Reference::where('reference_from', $userId)->get();
    
        return view('thanksnote.create', compact('thanksnoteMembers', 'references'));
    }
    

    // Store the Thanksnote data
    public function store(Request $request)
    {
        $request->validate([
            'thanksnote_to' => 'required|exists:members,id',
            'reference_id' => 'required|exists:member_references,id',
            'thanksnote_title' => 'required|string|max:255',
            'thanksnote_amount' => 'required|numeric|max:999999999999999',
        ]);

        Thanksnote::create([
            'source_member_id' => Auth::id(),
            'thanksnote_to' => $request->thanksnote_to,
            'reference_id' => $request->reference_id,
            'thanksnote_title' => $request->thanksnote_title,
            'thanksnote_amount' => $request->thanksnote_amount,
            'date' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Thanksnote successfully raised!');
    }

    // Show the Thanksnote Report
    public function report()
    {
        $userId = auth()->id(); // Get logged-in user ID
    
        // Fetch only the Thanksnotes given by the logged-in user, ordered by most recent first
        $thanksnotes = Thanksnote::where('source_member_id', $userId)
            ->orderBy('created_at', 'desc') // Order by latest created first
            ->get();
    
        // Return the view with the data
        return view('thanksnote.report', compact('thanksnotes'));
    }
    
    


    public function getReferences($memberId)
    {
        Log::info("Fetching references for Member ID: " . $memberId);
    
        // Ensure you get only references where the logged-in user is in reference_to
        $references = Reference::where('reference_from', $memberId)
            ->where('reference_to', auth()->id()) // Filter for logged-in user
            ->get(['id', 'title', 'amount']);
    
        Log::info("References Found: " . $references->count());
    
        return response()->json($references);
    }
    
    
    public function getDuePayments($referenceId)
    {
        $duePayments = Thanksnote::where('reference_id', $referenceId)
            ->select('thanksnote_title as title', 'thanksnote_amount as amount', 'created_at as date')
            ->orderBy('created_at', 'asc')
            ->get();
    
        return response()->json($duePayments);
    }
    

    public function received()
    {
        $userId = auth()->id(); // Get the logged-in user's ID
    
        // Fetch thanksnotes where the logged-in user is the receiver, ordered by most recent first
        $receivedThanksnotes = Thanksnote::where('thanksnote_to', $userId)
            ->orderBy('created_at', 'desc') // Order by latest created first
            ->get();
    
        return view('thanksnote.received', compact('receivedThanksnotes'));
    }
    

}    
