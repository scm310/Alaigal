<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Highlight;

class HighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::all();
        return view('highlight.index', compact('highlights'));
    }

    public function create()
    {
        return view('highlight.create');
    }

 
    public function store(Request $request)
    {
        // Check if the number of highlights already reached 5
        if (Highlight::count() >= 5) {
            return redirect()->route('highlight.index')->with('error', 'Only 5 highlights are allowed.');
        }
    
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Create the new highlight
        Highlight::create([
            'name' => $request->input('name'),
        ]);
    
        return redirect()->route('highlight.index')->with('success', 'Highlight added successfully.');
    }
    
    
    
    

    public function edit($id)
    {
        $highlight = Highlight::findOrFail($id);
        return view('highlight.edit', compact('highlight'));
    }
    
    public function update(Request $request, $id)
    {
        $highlight = Highlight::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
         
        ]);

      

        $highlight->update([
            'name' => $request->name,
          
        ]);

        return redirect()->route('highlight.index')->with('success', 'Highlight updated successfully.');
    }

    public function destroy($id)
    {
        Highlight::destroy($id);
        return redirect()->route('highlight.index')->with('success', 'Highlight deleted successfully.');
    }
}
