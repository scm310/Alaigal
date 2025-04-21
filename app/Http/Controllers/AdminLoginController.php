<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Members;
use App\Models\Product;
use App\Models\Reference;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {

        $favicon = DB::table('favicons')->latest()->first(); // Fetch the latest favicon entry
        return view('admin.layout.login', compact('favicon'));  // This is the HTML page you posted
    }


    public function login(Request $request)
    {
        // Validate the login form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the credentials are valid
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $admin->password == $request->password) {
            // Store user information in the session and redirect to the dashboard
            session(['admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        } else {
            // Return back with an error message
            return back()->withErrors(['credentials' => 'Invalid email or password']);
        }
    }



    public function dashboard()
    {
        // Check if the user is authenticated
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        // Get the count of members from the users table
        $membersCount = Members::where('payment', 1)->count();

        // Get the count of clients from the clients table
        $totalAmount = DB::table('member_references')->sum('amount');

        // Get the count of products from the products table
        $totalAmounts = DB::table('member_thanksnote')->sum('thanksnote_amount');

        $referenceCount = DB::table('member_references')->count();

        $topReferrer = DB::table('member_references')
            ->select('reference_from', DB::raw('COUNT(*) as total'))
            ->groupBy('reference_from')
            ->orderByDesc('total')
            ->first();

        $members = DB::table('members')
            ->select('id', 'first_name', 'last_name', 'profile_photo')
            ->get();



            $topThanksNote = DB::table('member_thanksnote')
            ->join('members', 'member_thanksnote.thanksnote_to', '=', 'members.id')
            ->select(
                'thanksnote_to as member_id',
                DB::raw('COUNT(*) as total_thanks'),
                'first_name',
                'last_name',
                'profile_photo'
            )
            ->groupBy('thanksnote_to', 'first_name', 'last_name', 'profile_photo')
            ->orderByDesc('total_thanks')
            ->first(); 



            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
        
            $topReferenceGiver = DB::table('member_references')
                ->join('members', 'member_references.reference_from', '=', 'members.id')
                ->select(
                    'member_references.reference_from as member_id',
                    'member_references.amount',
                    'first_name',
                    'last_name',
                    'profile_photo'
                )
                ->whereBetween('member_references.created_at', [$startOfWeek, $endOfWeek])
                ->orderByDesc('member_references.amount')
                ->first();
        

                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
            
                $topThanksNoteGiver = DB::table('member_thanksnote')
                    ->join('members', 'member_thanksnote.source_member_id', '=', 'members.id')
                    ->select(
                        'member_thanksnote.source_member_id as member_id',
                        'member_thanksnote.thanksnote_amount',
                        'first_name',
                        'last_name',
                        'profile_photo'
                    )
                    ->whereBetween('member_thanksnote.created_at', [$startOfWeek, $endOfWeek])
                    ->orderByDesc('member_thanksnote.thanksnote_amount')
                    ->first();
            

        // Get the count of newly registered users today
        $newMembersCount = Members::whereDate('created_at', Carbon::today())->count();

        // Fetch members along with counts of their associated data
        $members = Members::withCount([
            'products',
            'services',
            'testimonials',
            'clients',
            'completedProjects'
        ])
            ->get()
            ->sortByDesc(function ($member) {
                return $member->products_count +
                    $member->services_count +
                    $member->testimonials_count +
                    $member->clients_count +
                    $member->completed_projects_count;
            })
            ->take(5); // Get only the top 5 members

        // Pass the counts and members data to the view
        return view('admin.layout.dashboard', compact('membersCount', 'totalAmount', 'totalAmounts', 'referenceCount', 'newMembersCount', 'members', 'topReferrer','topThanksNote','topReferenceGiver','topThanksNoteGiver'));
    }
}
