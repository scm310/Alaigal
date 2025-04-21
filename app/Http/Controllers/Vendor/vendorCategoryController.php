<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class vendorCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('vendor.category.index', compact('categories'));
    }

    public function create()
    {
        return view('vendor.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('vendor.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
