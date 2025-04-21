<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Unit;


class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('created_at', 'DESC')->get();
        return view('unit.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit' => 'required|string',
            'abbreviation' => 'required|string',
        ]);

        Unit::create([
            'unit' => $request->unit,
            'abbreviation' => $request->abbreviation,
        ]);

        return redirect()->route('units.index')->with('success', 'UOM created successfully.');
    }

    public function edit($id)
    {
       
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unit' => 'required|string',
            'abbreviation' => 'required|string',
        ]);
    
        $unit = Unit::findOrFail($id);
    
        // Check if there are changes
        if ($unit->unit === $request->unit && $unit->abbreviation === $request->abbreviation) {
            return redirect()->route('units.index')->with('info', 'No changes were made.');
        }
    
        $unit->update([
            'unit' => $request->unit,
            'abbreviation' => $request->abbreviation,
        ]);
    
        return redirect()->route('units.index')->with('success', 'UOM updated successfully.');
    }
    

    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return redirect()->route('units.index')->with('success', 'UOM deleted successfully.');
    }
}