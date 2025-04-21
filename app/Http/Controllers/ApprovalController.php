<?php

namespace App\Http\Controllers;

use App\Mail\VendorActivatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApprovalController extends Controller
{
    public function index()
    {
        return view('approval.index'); // Main approval page
    }

   
   

    public function vendorApproval()
{
    // Fetch vendors and order them by 'name' in descending order
    $vendors = DB::table('vendor_registers')
                ->select('id', 'name', 'company_name', 'email', 'phone', 'status')
                ->orderBy('created_at', 'DESC')  // Order by 'name' in descending order
                ->get();
    
    return view('Approval.vendor_approval', compact('vendors'));
}

    
    

    public function vendorView($id)
    {
        $vendor = DB::table('vendor_registers')->where('id', $id)->first();
    
        return view('Approval.vendor_approval_view', compact('vendor'));
    }

    public function approveVendor($id)
    {
        $vendor = DB::table('vendor_registers')->where('id', $id)->first();

        if ($vendor->status == 'pending' || $vendor->status == 'deactivated') {
            DB::table('vendor_registers')
                ->where('id', $id)
                ->update(['status' => 'approved']);

            // Send Activation Email
            $this->sendActivationEmail($vendor);

            return redirect()->back()->with('success', 'Vendor approved successfully and activation email sent.');
        }

        return redirect()->back()->with('error', 'Action not allowed.');
    }
    
    public function deactivateVendor($id)
    {
        $vendor = DB::table('vendor_registers')->where('id', $id)->first();
        if ($vendor->status == 'approved') {
            DB::table('vendor_registers')
                ->where('id', $id)
                ->update(['status' => 'rejected']);

            return redirect()->back()->with('success', 'Vendor rejected successfully.');
        }

        return redirect()->back()->with('error', 'Action not allowed.');
    }
    public function updateVendorStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,deactivated',
        ]);

        $vendor = DB::table('vendor_registers')->where('id', $id)->first();

        if (!$vendor) {
            return redirect()->back()->with('error', 'Vendor not found.');
        }

        // If status is being changed to approved, send email with login details
        if ($validated['status'] == 'approved' && $vendor->status !== 'approved') {
            $generatedPassword = Str::random(8); // Generate a random 8-character password

            // Update the vendor's password in the database (hashed for security)
            DB::table('vendor_registers')->where('id', $id)->update([
                'status' => 'approved',
                'password' => bcrypt($generatedPassword),
            ]);

            // Send activation email
            $this->sendActivationEmail($vendor, $generatedPassword);
        } else {
            // Just update status without changing the password
            DB::table('vendor_registers')->where('id', $id)->update(['status' => $validated['status']]);
        }

        return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }
    



public function categoryApproval()
{
    $categories = DB::table('category')
        ->select('Category_id', 'Category_name', 'vendor_category_status')
        ->get();

    return view('approval.category', compact('categories'));
}
public function updateCategoryStatus(Request $request, $id)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    DB::table('category')
        ->where('Category_id', $id)
        ->update(['vendor_category_status' => $validated['status']]);

    return redirect()->back()->with('success', 'Category status updated successfully.');
}

public function approvedVendors()
{
    // Fetching vendors where status is 'approved' and ordering by creation date in descending order
    $vendors = DB::table('vendor_registers')
        ->where('status', 'approved')
        ->orderBy('created_at', 'DESC') // Ordering by latest created vendors first
        ->get();

    return view('Approval.approved', compact('vendors'));
}


public function rejectedVendors()
{
    // Fetching vendors where status is 'deactivated' and ordering by creation date in descending order
    $vendors = DB::table('vendor_registers')
        ->where('status', 'deactivated')
        ->orderBy('created_at', 'DESC') // Ordering by latest created vendors first
        ->get();

    return view('Approval.rejected', compact('vendors'));
}


    private function sendActivationEmail($vendor)
    {
        // Generate a new random password
        $generatedPassword = Str::random(8);
        $hashedPassword = bcrypt($generatedPassword);
    
        // Update the vendor's password in the database
        DB::table('vendor_registers')->where('id', $vendor->id)->update([
            'password' => $hashedPassword,
        ]);
    
        // Send email with the generated password
        Mail::to($vendor->email)->send(new VendorActivatedMail($vendor, $generatedPassword));

    }

    
    
    


}
