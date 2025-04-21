<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\VehicleType;
use App\Models\BodyType;
use App\Models\WorkType;
use App\Models\VehicleVariants;
use App\Models\BodyVariants;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
      public function index()
    {
        $user = auth()->user(); // Get the authenticated user
    
        // If the user is super admin, fetch all records; otherwise, fetch only their records
        if ($user->role_id == 1) {
            $units = Unit::orderBy('created_at', 'desc')->get();
            $categories = Category::all();
        } else {
            $units = Unit::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            $categories = Category::where('user_id', $user->id)->get();
        }
    
        // Pass data to the settings view
        return view('task.settings', compact('units', 'categories'));
    }
    
    

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'designation_name' => 'required|string|max:255',
            'shift' => 'required|string',
            'working_from' => 'required',
            'working_to' => 'required',
            'total_work_hours_per_day' => 'required|numeric',
        ]);

        // Create a new Setting instance
        $setting = new Setting();
        $setting->designation_name = $request->designation_name;
        $setting->shift = $request->shift;
        $setting->working_from = $request->working_from;
        $setting->working_to = $request->working_to;
        $setting->total_work_hours_per_day = $request->total_work_hours_per_day;

        // Save the setting
        $setting->save();

        // Redirect back with success message
        return redirect()->route('settings.index')->with('success', 'Designation added successfully!');
    }

  
    public function storeuom(Request $request)
    {
        // Validate the UOM data
        $request->validate([
            'unit' => 'required|string|max:255',  // Matching form field name
            'abbreviation' => 'required|string|max:10',  // Matching form field name
        ]);
    
        // Create a new Unit (UOM) instance
        $unit = new Unit();
        $unit->unit = $request->unit;  // Matching form field name
        $unit->abbreviation = $request->abbreviation;  // Matching form field name
    
        // Save the UOM
        $unit->save();
    
        // Redirect back with success message
        return redirect()->route('settings.index', ['tab' => 'uom'])->with('success', 'Unit of Measurement added successfully!');
    }
    
       public function updateuom(Request $request)
    {
        // Validate the UOM data
        $request->validate([
            'unit' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
        ]);
    
        // Find the Unit by ID
        $unit = Unit::findOrFail($request->edit_uom_id);
        $unit->unit = $request->unit;
        $unit->abbreviation = $request->abbreviation;
    
        // Save the updated Unit
        $unit->save();
    
        // Redirect back with success message
        return redirect()->route('settings.index', ['tab' => 'uom'])->with('success', 'Unit of Measurement updated successfully!');
    }
    

public function destroyuom($id)
{
    $unit = Unit::findOrFail($id);
    $unit->delete();
    return redirect()->route('settings.index', ['tab' => 'uom'])->with('success', 'Unit of Measurement deleted successfully!');
}




   
public function update(Request $request)
{
    // Validate the request data
    $request->validate([
        'designation_name' => 'required|string|max:255',
        'shift' => 'required|string',
        'working_from' => 'required',
        'working_to' => 'required',
        'total_work_hours_per_day' => 'required|numeric',
        'editId' => 'required|integer|exists:settings,id', // Ensure the ID exists in the settings table
    ]);

    // Find the Setting by ID
    $setting = Setting::findOrFail($request->editId);

    // Update the Setting fields
    $setting->designation_name = $request->designation_name;
    $setting->shift = $request->shift;
    $setting->working_from = $request->working_from;
    $setting->working_to = $request->working_to;
    $setting->total_work_hours_per_day = $request->total_work_hours_per_day;

    // Save the updated Setting
    $setting->save();

    // Redirect back with success message
    return redirect()->route('settings.index')->with('success', 'Designation updated successfully!');
}








  







}
