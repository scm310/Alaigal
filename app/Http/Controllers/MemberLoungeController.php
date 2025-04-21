<?php
namespace App\Http\Controllers;

use App\Models\Members;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class MemberLoungeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
    
        $members = Members::where('approve_status', 1)
            ->where('payment', 1)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $terms = explode(' ', $search);
    
                    if (count($terms) >= 2) {
                        // Full name search
                        $first = $terms[0];
                        $last = $terms[1];
    
                        $q->where(function ($subQ) use ($first, $last) {
                            $subQ->where('first_name', 'like', "%$first%")
                                 ->where('last_name', 'like', "%$last%");
                        });
                    }
    
                    // Also support single word search
                    $q->orWhere('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('company_name', 'like', "%$search%")
                      ->orWhere('phone_number', 'like', "%$search%");
                });
            })
            ->orderBy('first_name')
            ->paginate(18);
    
        return view('memberlounge.member-lounge', compact('members', 'search'));
    }
    
    
    
    

    public function viewProfile($id)
    {
        // Fetch the member with an approved status
        $member = Members::where('approve_status', 1)->find($id);
    
        if (!$member) {
            return response()->json(["error" => "Member not found"], 404);
        }
    
        // Fetch products & services from their respective tables
        $products = DB::table('products')->where('user_id', $id)->get();
        $services = DB::table('services')->where('user_id', $id)->get();
        
        // Fetch clients from multiple tables
        $clients = DB::table('clients')->where('user_id', $id)->get()
            ->merge(DB::table('testimonials')->where('user_id', $id)->get())
            ->merge(DB::table('completed_projects')->where('user_id', $id)->get());
    
        // Fetch testimonials separately
        $testimonials = DB::table('testimonials')->where('user_id', $id)->get();
    
        // Fetch completed projects
        $completed_projects = DB::table('completed_projects')->where('user_id', $id)->get();
    
        return view('memberlounge.member-profile', compact('member', 'products', 'services', 'clients', 'testimonials', 'completed_projects'));
    }
    
    



}
