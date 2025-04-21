<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientTestimonial;
use Illuminate\Support\Facades\Storage;

class ClientTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = ClientTestimonial::all();
        return view('homepage_settings.client_testimonial', compact('testimonials'));
    }

    public function create()
    {
        return view('homepage_settings.client_testimonial');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('client_testimonials', 'public');
        }

        ClientTestimonial::create([
            'name' => $request->name,
            'message' => $request->message,
            'image' => $imagePath
        ]);

        return redirect()->route('client_testimonials.index')->with('success', 'Testimonial added successfully!');
    }


    public function destroy($id)
    {
        $testimonial = ClientTestimonial::findOrFail($id);

        if ($testimonial->image) {
            Storage::delete('public/' . $testimonial->image);
        }

        $testimonial->delete();
        return redirect()->route('client_testimonials.index')->with('success', 'Testimonial deleted successfully!');
    }
}

