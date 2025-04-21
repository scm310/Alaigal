<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    // Show the update password form
    public function showUpdateForm()
    {
        return view('auth.update-password');  // Return the update password form view
    }



    public function updatePassword(Request $request)
    {
        // Validate the input data
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:4',
        ]);

        // Get the currently authenticated member
        $member = Auth::guard('member')->user();

        // Check if the current password matches the stored password
        if (!Hash::check($request->current_password, $member->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Check if the new password is the same as the current password
        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'New password cannot be the same as the current password']);
        }

        // Update the member's password
        $member->password = Hash::make($request->new_password);
        $member->save();

        return redirect()->route('update-password.form')->with('success', 'Password updated successfully!');
    }

}
