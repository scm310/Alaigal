<?php
namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class ApprovememberController extends Controller
{
    public function approveMember()
    {
        // Fetch only approved users and order them by the latest approved first
        $approvedUsers = Members::where('approve_status', 1)
                             ->orderBy('updated_at', 'desc') // Order by latest update
                             ->get();

        return view('admin.approvemember', compact('approvedUsers'));
    }


    public function rejectedMember()
    {
        // Fetch users with `approved_status = 0` (Rejected Members)
        $rejectedUsers = Members::where('approve_status', 3)->get();

        return view('admin.rejected', compact('rejectedUsers'));
    }


}

