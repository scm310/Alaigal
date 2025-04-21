<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CompletedProject;

use App\Models\Members;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $user->refresh();

        $products = $user->products ?? collect();
        $chart = $user;

        if (!$chart) {
            return redirect()->back()->with('error', 'User chart data not found.');
        }



        $descriptiondata = [
            'percentage1' => $chart->det ? null : "Please fill in the details.",
            'percentage2' => ($chart->pro || $chart->ser) ? null : "Please add services or products.",
            'percentage3' => $chart->cli ? null : "No clients added.",
            'percentage4' => $chart->tem ? null : "No testimonials available.",
            'percentage5' => $chart->proj ? null : "No projects added.",
        ];

        $cdata = [
            'percentage1' => $chart->det ? 100 : 0,
            'percentage2' => ($chart->pro || $chart->ser) ? 100 : 0,
            'percentage3' => $chart->cli ? 100 : 0,
            'percentage4' => $chart->tem ? 100 : 0,
            'percentage5' => $chart->proj ? 100 : 0,
        ];

        $isComplete = $chart->det && ($chart->pro || $chart->ser) && $chart->cli && $chart->tem && $chart->proj;

        $chart->update(['profile_update' => $isComplete ? 1 : 0]);

        return view('members.profile', compact('user', 'products', 'cdata', 'descriptiondata'));
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // 🔹 Ensure we use the correct guard

        if (!$user) {

            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:10',
            'pincode' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);


    if ($request->hasFile('profile_photo')) {

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);

        }

        // Store the new profile photo
        $file = $request->file('profile_photo');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $profilePhotoPath = $file->storeAs('profile_photos', $filename, 'public');

        $validatedData['profile_photo'] = $profilePhotoPath;
    }



        $user->update($validatedData);

        $member = Members::find($user->id);

        if ($member) {
            $member->refresh();
            $member->update(['det' =>  1 ]);
        }

        // 🔍 Fetch latest from DB
        $updatedUser = $user->fresh();

        return redirect()->back()->with([
            'success' => 'Profile updated successfully!',
            'nextTab' => '#products'
        ]);
    }


    public function saveProducts(Request $request)
    {
         $user = Auth::user(); // ✅ Use correct auth guard

         $user->refresh();
        if (!$user) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }


        $validatedData = $request->validate([
            'product_name'   => 'nullable|array',
            'product_name.*' => 'nullable|string|max:255',
            'product_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $existingProducts = Product::where('user_id', $user->id)->get();
            $existingImages = $existingProducts->pluck('product_image', 'product_name')->toArray();

            Product::where('user_id', $user->id)->delete();

            $productInserted = false;

            if (!empty($request->product_name)) {
                foreach ($request->product_name as $key => $productName) {
                    if (!empty($productName)) {
                        $productImagePath = $existingImages[$productName] ?? null; // Keep previous image if exists

                        // If new image is uploaded, replace the previous one
                        if ($request->hasFile("product_image.$key")) {
                            $file = $request->file("product_image.$key");
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $productImagePath = $file->storeAs('products', $filename, 'public');




                        }

                        Product::create([
                            'user_id'       => $user->id,
                            'product_name'  => $productName,
                            'product_image' => $productImagePath,
                        ]);

                        $productInserted = true;
                    }
                }
            }

            $member = Members::find($user->id);

            if ($member) {
                $member->refresh();
                $member->update(['pro' => $productInserted ? 1 : 0]);
            }


            return redirect()->back()->with([
                'success' => 'Products saved successfully!',
            ])->withInput()->with('nextTab', '#services'); // ✅ Store next tab correctly

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving products. Please try again.');
        }
    }



    public function saveServices(Request $request)
    {
        $user = Auth::guard('member')->user(); // ✅ Use correct auth guard

        if (!$user) {

            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate request
        $validatedData = $request->validate([
            'service_name'   => 'nullable|array',
            'service_name.*' => 'nullable|string|max:255',
            'service_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Fetch existing services for the user
            $existingServices = Service::where('user_id', $user->id)->get();
            $existingImages = $existingServices->pluck('service_image', 'service_name')->toArray();

            // 🗑️ Delete old services but keep previous image references
            Service::where('user_id', $user->id)->delete();

            $serviceInserted = false; // Track if at least one service is inserted

            if (!empty($request->service_name)) {
                foreach ($request->service_name as $key => $serviceName) {
                    if (!empty($serviceName)) {
                        $serviceImagePath = $existingImages[$serviceName] ?? null; // Retain old image if exists

                        // If a new image is uploaded, replace the previous one
                        if ($request->hasFile("service_image.$key")) {
                            $file = $request->file("service_image.$key");
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $serviceImagePath = $file->storeAs('services', $filename, 'public');



                        }

                        // ✅ Save new service with updated or retained image
                        Service::create([
                            'user_id'       => $user->id,
                            'service_name'  => $serviceName,
                            'service_image' => $serviceImagePath,
                        ]);

                        $serviceInserted = true; // Mark that a service was inserted
                    }
                }
            }

            $member = Members::find($user->id);

            if ($member) {
                $member->refresh();
                $member->update(['ser' => $serviceInserted ? 1 : 0]);
            }

            return redirect()->back()->with([
                'success' => 'Services saved successfully!',
            ])->withInput()->with('nextTab', '#clients'); // ✅ Store next tab correctly

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while saving services. Please try again.');
        }
    }




public function saveClients(Request $request)
{
    $user = Auth::guard('member')->user(); // Get the authenticated member

    if (!$user) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    $validatedData = $request->validate([
        'client_name' => 'nullable|array',
        'client_name.*' => 'nullable|string|max:255',
        'company_name.*' => 'nullable|string|max:255',
        'company_fullform.*' => 'nullable|string|max:255',
        'designation.*' => 'nullable|string|max:255',
    ]);

    // Delete old records of this member
    Client::where('user_id', $user->id)->delete();

    $clientInserted = false; // Track if any client is inserted

    if (!empty($request->client_name)) {
        foreach ($request->client_name as $key => $clientName) {
            if (!empty($clientName)) {
                Client::create([
                    'user_id' => $user->id,
                    'client_name' => $clientName,
                    'company_name' => $request->company_name[$key] ?? null,
                    'company_fullform' => $request->company_fullform[$key] ?? null,
                    'designation' => $request->designation[$key] ?? null,
                ]);
                $clientInserted = true; // At least one client is inserted
            }
        }
    }


    $member = Members::find($user->id);

    if ($member) {
        $member->refresh();
        $member->update(['cli' => $clientInserted ? 1 : 0]);
    }
    // If clients exist, set `cli = 1`, otherwise set `cli = 0`

    return redirect()->back()->with([
        'success' => 'Clients saved successfully!',
        'nextTab' => '#testimonials'
    ]);
}




public function saveTestimonials(Request $request)
{
    $user = Auth::guard('member')->user(); // ✅ Use correct auth guard

    if (!$user) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    $validatedData = $request->validate([
        'client_name' => 'nullable|array',
        'client_name.*' => 'nullable|string|max:255',
        'company_name.*' => 'nullable|string|max:255',
        'designation.*' => 'nullable|string|max:255',
        'content.*' => 'nullable|string',
        'testimonial_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Fetch existing testimonials for the user
        $existingTestimonials = Testimonial::where('user_id', $user->id)->get();
        $existingImages = $existingTestimonials->pluck('testimonial_image', 'client_name')->toArray();

        // 🗑️ Delete old testimonials while keeping image references
        Testimonial::where('user_id', $user->id)->delete();

        $testimonialInserted = false; // Track if any testimonial is inserted

        if (!empty($request->client_name)) {
            foreach ($request->client_name as $key => $clientName) {
                if (!empty($clientName)) {
                    $imagePath = $existingImages[$clientName] ?? null; // Keep previous image if available

                    // If a new image is uploaded, replace the previous one
                    if ($request->hasFile("testimonial_image.$key")) {
                        $file = $request->file("testimonial_image.$key");
                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $imagePath = $file->storeAs('testimonials', $filename, 'public');


                    }

                    // ✅ Save new testimonial with updated or retained image
                    Testimonial::create([
                        'user_id' => $user->id,
                        'client_name' => $clientName,
                        'company_name' => $request->company_name[$key] ?? null,
                        'designation' => $request->designation[$key] ?? null,
                        'content' => $request->content[$key] ?? '',
                        'testimonial_image' => $imagePath,
                    ]);

                    $testimonialInserted = true;
                }
            }
        }

        $member = Members::find($user->id);

    if ($member) {
        $member->refresh();
        $member->update(['tem' => $testimonialInserted ? 1 : 0]);
    }



        return redirect()->back()->with([
            'success' => 'Testimonials saved successfully!',
            'nextTab' => '#projects', // ✅ Store next tab correctly
        ]);

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while saving testimonials. Please try again.');
    }
}






public function saveProjects(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    // ✅ Validate input fields
    $validatedData = $request->validate([
        'project_name'   => 'nullable|array', // Limit to 5 projects per request
        'project_name.*' => 'nullable|string|max:255',
        'company_name'   => 'nullable|array',
        'company_name.*' => 'nullable|string|max:255',
        'location'       => 'nullable|array',
        'location.*'     => 'nullable|string|max:255',
        'client_name'    => 'nullable|array',
        'client_name.*'  => 'nullable|string|max:255',
        'project_image'  => 'nullable|array',
        'project_image.*'=> 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
       // ✅ Start transaction for atomicity

        // Get existing project images
        $existingImages = CompletedProject::where('user_id', $user->id)
            ->pluck('project_image', 'project_name')
            ->toArray();

        // Remove empty project names
        $newProjectNames = array_filter($request->project_name ?? []);



            CompletedProject::where('user_id', $user->id)->delete();


        $insertedProjects = false;

        // ✅ Process new projects
        foreach ($newProjectNames as $key => $projectName) {
            $imagePath = $existingImages[$projectName] ?? null; // Retain old image if exists

            // Check if a new image is uploaded
            if ($request->hasFile("project_image.$key")) {
                $file = $request->file("project_image.$key");
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('projects', $filename, 'public');
            }

            CompletedProject::create([
                'user_id'       => $user->id,
                'project_name'  => $projectName,
                'company_name'  => $request->company_name[$key] ?? null,
                'location'      => $request->location[$key] ?? null,
                'client_name'   => $request->client_name[$key] ?? null,
                'project_image' => $imagePath,
            ]);

            $insertedProjects = true;
        }

        // ✅ Update member record only if a project was inserted
        $member = Members::find($user->id);
        $member->refresh();
        if ($member) {
            $member->update(['proj' => $insertedProjects ? 1 : 0]);
        }



        return redirect()->back()->with([
            'success' => 'Projects saved successfully!',
            'nextTab' => '#basicInfo'
        ]);

    } catch (\Exception $e) {


        return redirect()->back()->with('error', 'An error occurred while saving projects. Please try again.');
    }
}



}
