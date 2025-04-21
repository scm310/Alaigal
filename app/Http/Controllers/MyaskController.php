<?php

namespace App\Http\Controllers;

use App\Models\MyAsk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MyaskController extends Controller
{

    public function showForm()
    {
        $user = Auth::guard('member')->user(); // Ensure the correct authentication guard
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
    
        // Fetch only the questions submitted by the logged-in member
        $asks = MyAsk::where('user_id', $user->id)
                     ->orderBy('created_at', 'desc')
                     ->get()
                     ->map(function($ask) {
                         $ask->formatted_date = Carbon::parse($ask->created_at)->format('d-m-Y h:i A');
                         return $ask;
                     });
    
        // Fetch all questions submitted by other users
        $allAsks = MyAsk::where('user_id', '!=', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->map(function($ask) {
                            $ask->formatted_date = Carbon::parse($ask->created_at)->format('d-m-Y h:i A');
                            return $ask;
                        });
    
        return view('my_ask.myaskform', compact('asks', 'allAsks'));
    }
    


    public function destroy($id)
{
    $ask = MyAsk::findOrFail($id);
    $ask->delete();

    return redirect()->back()->with('delete_success', 'Your Ask deleted successfully!');
}


public function submitForm(Request $request)
{
    // ✅ Ensure user is authenticated
    $user = Auth::guard('member')->user();

    if (!$user) {
        Log::error('❌ Authentication failed: User ID is null.');
        return redirect()->back()->with('error', 'Unauthorized. Please log in.');
    }

    // 📝 Validate input
    $request->validate([
        'date' => 'required|date',
        'ask' => 'required|string|max:300',
    ]);

    // 🕒 Convert the date to the correct timezone before storing
    $dateTime = Carbon::parse($request->input('date'))
                      ->setTime(now()->hour, now()->minute, now()->second)
                      ->timezone(config('app.timezone')); // Ensure correct timezone

    MyAsk::create([
        'user_id' => $user->id,
        'date' => $dateTime, // ✅ Store correct timezone
        'my_ask' => $request->input('ask'),
    ]);

    Log::info("✅ Question submitted by User ID: {$user->id} on {$dateTime}");

    return redirect()->route('ask.form')->with('success', 'Your Ask has been submitted!');
}




public function index()
{
    $asks = MyAsk::with('member')->orderBy('created_at', 'desc')->get();

    return view('admin.myask_list', compact('asks'));
}

public function askList()
{
    $user = Auth::guard('member')->user(); // Ensure correct authentication

    if (!$user) {
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    // 🛠️ Fetch asks but EXCLUDE logged-in user
    $allAsks = MyAsk::with('member')
        ->where('user_id', '!=', $user->id) // Exclude logged-in user
        ->orderBy('created_at', 'desc')
        ->get();

    return view('my_ask.asklist', compact('allAsks'));
}


}
