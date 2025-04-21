<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class UserController extends Controller
{
    public function index() {
        return view('user.index');
    }

    public function about() {
        return view('user.about');
    }

  public function gallery() {
        // Fetch vehicles that should be shown in the gallery, grouped by gallery category
        $vehicles = DB::table('vehicle')
            ->where('show_in_gallery', 1)
            ->select('gallery_category', 'vehicle_final_image')
            ->orderBy('gallery_category')
            ->get()
            ->groupBy('gallery_category');

        // Pass the grouped data to the view
        return view('user.gallery', compact('vehicles'));
    }

    public function contact() {
        return view('user.contact');
    }

    public function login() {
        return view('user.login');
    }

    public function user()
    {
        $users = User::with('role')->get();
        $roles = Role::all(); // Fetch all roles from the database

        return view('admin.user.manage-users', ['users' => $users, 'roles' => $roles]); // Pass roles to the view
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles from the database
        return view('admin.user.create', ['roles' => $roles]); // Pass roles to the view
    }
    public function store(Request $request)
    {
        // Uncomment this line to dump request data for debugging
        // dd($request->all());
       /*
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'role' => 'required|exists:roles,id',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);*/
    
        $profilePicturePath = null;
    
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('/admin_assets/assets/img/faces/profile', 'public');
        }
    
        $user = new User([
            'name' => $request->username, // Assuming your user model uses 'name' for the username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_pic' => $profilePicturePath ? $profilePicturePath : '/admin_assets/assets/img/faces/profile/profile-pic.png',
            'role_id' => $request->role,
        ]);
        
     
        
    
        $user->save();
    
        // 2. Send Confirmation Email
require base_path('phpmailer/src/Exception.php');
        require base_path('phpmailer/src/PHPMailer.php');
        require base_path('phpmailer/src/SMTP.php');

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'sakthibodyworks.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@sakthibodyworks.com';
    $mail->Password   = 'pz4QPmM~cWa+';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('info@sakthibodyworks.com', 'Sakthi Body Works');
    $mail->addAddress($request->email, $request->username);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Welcome to Sakthi Body Works';
    $mail->Body    = '<p>Dear ' . $request->username . ',</p>
                      <p>Thank you for registering with Sakthi Body Works!</p>
                      <p>Your account details:</p>
                      <ul>
                        <li><strong>Email:</strong> ' . $request->email . '</li>
                        <li><strong>Password:</strong> ' . $request->password . '</li>
                        <li><strong>Login URL:</strong><a href="http://sakthibodyworks.com/login">Login</a></li>
                      </ul>
                      <p>We look forward to having you onboard.</p>
                      <p>Best regards,<br>
                      Sakthi Body Works</p>';

    // Send email
    $mail->send();

    return redirect()->back()->with('success', 'User registered successfully. Confirmation email sent.');
} catch (Exception $e) {
    return redirect()->back()->with('error', 'User registered, but confirmation email could not be sent. Error: ' . $mail->ErrorInfo);
}
    }
    

    public function createRole()
    {
        $roles = Role::all();
        return view('user.createrole', ['roles' => $roles]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,role',
        ]);

        $role = Role::create([
            'role' => $request->role_name,
        ]);

        return redirect()->back()->with('success', 'Role created successfully!');
    }

    // UserController.php

public function destroy(User $user)
{
    try {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error deleting user.']);
    }
}

}
