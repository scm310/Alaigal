<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Reference;
use App\Models\Members;
use Illuminate\Support\Facades\Auth;

class ReferenceController extends Controller
{

    public function index()
    {
        $memberId = auth()->guard('member')->id();
    
        // Fetch Reference Given
        $givenReferences = Reference::where('reference_from', $memberId)
            ->with(['givenTo', 'givenBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Fetch Reference Received
        $receivedReferences = Reference::where('reference_to', $memberId)
            ->with(['givenBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('references.index', compact('givenReferences', 'receivedReferences'));
    }
    
    
    
    
    public function create()
    {
        $loggedInMemberId = auth()->guard('member')->id(); // Get logged-in member's ID
    
        $members = Members::where('id', '!=', $loggedInMemberId) // Exclude logged-in member
                          ->orderBy('first_name', 'asc')
                          ->get();
    
        return view('references.create', compact('members'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'reference_to' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|max:9999999999.99',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Max size 1MB
            'details' => 'required|string',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('references', 'public');
        }

        Reference::create([
            'reference_to' => $request->reference_to,
            'reference_from' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => now(),
            'image' => $imagePath,
            'details' => $request->details,
        ]);

        return redirect()->route('references.create')->with('success', 'Reference created successfully.');
    }
//reference given report
public function report()
{
    // Get only the references given by the logged-in user, ordered by most recent first
    $references = Reference::where('reference_from', auth()->user()->id)
        ->with(['givenTo', 'givenBy'])
        ->orderBy('created_at', 'desc') // Order by latest created first
        ->get();

    return view('references.report', compact('references'));
}


//reference received report
public function received()
{
    $loggedInMemberId = auth()->id(); // Get the logged-in member ID

    $receivedReferences = Reference::where('reference_to', $loggedInMemberId)
        ->with(['givenBy']) // Load the member who gave the reference
        ->orderBy('created_at', 'desc') // Order by latest created first
        ->get();

    return view('references.received', compact('receivedReferences'));
}

    
public function onBehalf()
{
    $members = Member::all(); // Make sure the Member model is imported
    return view('references.onbehalf_form', compact('members'));
}

 
public function storeOnBehalf(Request $request)
{
    $request->validate([
        'reference_by' => 'required|exists:members,id',
        'reference_to' => 'required|exists:members,id',
        'title'        => 'required|string|max:25',
        'amount'       => 'required|numeric|min:1|max:999999999999999',
        'details'      => 'nullable|string|max:250',
        'image'        => 'nullable|image|max:1024',
    ]);

    $reference = new Reference();
    $reference->reference_from = $request->reference_by; // Who the reference is on behalf of
    $reference->reference_by   = auth()->id(); // Who is actually submitting it
    $reference->reference_to   = $request->reference_to;
    $reference->title          = $request->title;
    $reference->amount         = $request->amount;
    $reference->details        = $request->details;
    $reference->reference_type = 'on_behalf';
    $reference->date           = now();

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('references', 'public');
        $reference->image = $imagePath;
    }

    $reference->save();

    return redirect()->route('references.onbehalf')->with('success', 'On Behalf of Reference Submitted Successfully.');
}



}
