<?php

namespace App\Http\Controllers;

use App\Models\CompletedProject;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Members;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientSearchController extends Controller
{
    public function index(Request $request)
    {
        $users = collect(); // Initialize as an empty collection
    
        // Fetch only companies where user_id belongs to a member with payment = 1
        $clients = DB::table('clients')
            ->whereIn('user_id', Members::where('payment', 1)->pluck('id'))
            ->select('company_name');
    
        $testimonials = DB::table('testimonials')
            ->whereIn('user_id', Members::where('payment', 1)->pluck('id'))
            ->select('company_name');
    
        $completedProjects = DB::table('completed_projects')
            ->whereIn('user_id', Members::where('payment', 1)->pluck('id'))
            ->select('company_name');
    
        $companies = $clients->union($testimonials)->union($completedProjects)->distinct()->get();
    
        // Generate A-Z letters for the alphabetical filter
        $allLetters = range('A', 'Z');
    
        // Fetch distinct first letters of company names from filtered companies
        $availableLetters = collect($companies)->pluck('company_name')->map(fn($name) => strtoupper(substr($name, 0, 1)))->unique()->toArray();
    
        // Fetch members who have payment = 1 and belong to at least one of the company-related tables
        $alphabeticalClients = Members::where('profile_update', 1)
            ->where('payment', 1) // Only paid members
            ->where(function ($query) {
                $query->whereHas('clients')
                      ->orWhereHas('testimonials')
                      ->orWhereHas('completedProjects');
            })
            ->with(['clients', 'testimonials', 'completedProjects'])
            ->orderBy('first_name', 'ASC')
            ->paginate(20);
    
        // Check if there's a search query
        if ($request->has('search')) {
            $search = $request->input('search');
    
            // Search for clients based on company_name in all three tables
            $clients = Client::where('company_name', 'LIKE', "%{$search}%")
                             ->orWhere('company_fullform', 'LIKE', "%{$search}%")
                             ->whereIn('user_id', Members::where('payment', 1)->pluck('id')) // Filter by paid users
                             ->get();
            $testimonials = Testimonial::where('company_name', 'LIKE', "%{$search}%")
                                       ->whereIn('user_id', Members::where('payment', 1)->pluck('id'))
                                       ->get();
            $completedProjects = CompletedProject::where('company_name', 'LIKE', "%{$search}%")
                                                 ->whereIn('user_id', Members::where('payment', 1)->pluck('id'))
                                                 ->get();
    
            // Collect user IDs from all sources
            $memberIds = collect()
                ->merge($clients->pluck('user_id'))
                ->merge($testimonials->pluck('user_id'))
                ->merge($completedProjects->pluck('user_id'))
                ->unique()
                ->filter(); // Removes null values
    
            // Fetch members based on the user IDs
            $users = Members::whereIn('id', $memberIds)
                ->where('profile_update', 1)
                ->where('payment', 1) // Only paid members
                ->where(function ($query) {
                    $query->whereHas('clients')
                          ->orWhereHas('testimonials')
                          ->orWhereHas('completedProjects');
                })
                ->with(['clients', 'testimonials', 'completedProjects'])
                ->get();
        }
    
        return view('clients.search', compact('users', 'companies', 'allLetters', 'availableLetters', 'alphabeticalClients'));
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
