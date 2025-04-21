<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $mainCategories = Category::orderBy('created_at', 'desc')->get(); // Order main categories by latest
    
        $query = Category::with('subcategories.childcategories')->orderBy('created_at', 'desc'); // Order categories by latest
    
        if ($request->mainCategory) {
            $query->where('Category_id', $request->mainCategory);
        }
        if ($request->subCategory) {
            $query->whereHas('subcategories', fn($q) => $q->where('id', $request->subCategory));
        }
        if ($request->childCategory) {
            $query->whereHas('subcategories.childcategories', fn($q) => $q->where('id', $request->childCategory));
        }
    
        $categories = $query->get();
    
        return view('categories.index', compact('categories', 'mainCategories'));
    }
    

    public function refreshFilters()
    {
        return redirect()->route('categories.index');
    }


    public function createMainCategory()
    {
        $recentCategories = Category::orderBy('created_at', 'desc')->take(2)->get();
        return view('categories.add_main_category', compact('recentCategories'));
    }

    public function storeMainCategory(Request $request)
    {
        $validated = $request->validate([
            'Category_name' => 'required|unique:category,Category_name', // Use 'category' instead of 'categories'
            'Category_image' => 'required|image|mimes:jpeg,png,jpg|max:150',
        ], [
            'Category_name.unique' => 'The category name already exists. Please choose a different name.',
        ]);


        $file = $request->file('Category_image');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // This works on cPanel, assuming public_html is root (one level up from app folder)
        $targetDirectory = dirname(__DIR__, 3) . '/main_category_images';

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $file->move($targetDirectory, $fileName);

        $category = Category::create([
            'Category_name' => $validated['Category_name'],
            'Category_image' => 'main_category_images/' . $fileName,
            'user_id' => auth()->id(),
        ]);

        return $request->has('saveAndCreateSub')
            ? redirect()->route('categories.createSub', $category->Category_id)
            ->with('success', 'Main category saved successfully! You can now create a subcategory.')
            : redirect()->route('categories.index')
            ->with('success', 'Main category saved successfully!');
    }





    public function createSubCategory($categoryId)
    {
        $mainCategory = Category::findOrFail($categoryId);

        // Correct path for main category image
        $mainCategory->Category_image = asset($mainCategory->Category_image);

        return view('categories.add_sub_category', compact('mainCategory'));
    }

    public function storeSubCategory(Request $request)
    {
        $subcategories = $request->subcategories;
        $duplicateSubcategories = [];
    
        // Step 1: Check for duplicates within the same request
        $subcategoryNames = array_column($subcategories, 'name');
        if (count($subcategoryNames) !== count(array_unique($subcategoryNames))) {
            return back()->withErrors(['subcategory_name' => 'Duplicate subcategory names found. Please rename them.'])
                         ->withInput();
        }
    
        // Step 2: Check for existing subcategories in the database
        foreach ($subcategories as $subcategory) {
            $existingSubcategory = Subcategory::where('category_id', $request->main_category_id)
                                              ->where('name', $subcategory['name'])
                                              ->exists();
    
            if ($existingSubcategory) {
                $duplicateSubcategories[] = $subcategory['name'];
            }
        }
    
        // If duplicate subcategories exist in the DB, return an error
        if (!empty($duplicateSubcategories)) {
            return back()->withErrors(['subcategory_name' => 'Duplicate entry: Please rename these subcategories: ' . implode(', ', $duplicateSubcategories)])
                         ->withInput();
        }
    
        // Step 3: Save valid subcategories
        foreach ($subcategories as $subcategory) {
            Subcategory::create([
                'category_id' => $request->main_category_id,
                'name' => $subcategory['name'],
                'user_id' => auth()->id(),
               
            ]);
        }
    
        return $request->has('saveAndCreateChild')
        ? redirect()->route('categories.createChild', [$request->main_category_id, 0])
        : redirect()->route('categories.index');
    }
    

    



    public function createChildCategory($categoryId, $subCategoryId)
    {
        $mainCategory = Category::findOrFail($categoryId);
        $subCategories = Subcategory::where('category_id', $categoryId)->get();
        return view('categories.add_child_category', compact('mainCategory', 'subCategories'));
    }

    public function storeChildCategory(Request $request)
    {
        foreach ($request->childcategories as $childcategory) {
            ChildCategory::create([
                'category_id' => $request->main_category_id,
                'subcategory_id' => $childcategory['subcategory_id'],  // FIXED
                'name' => $childcategory['name'],
                'user_id' => auth()->id(),
                'image' => $childcategory['image'],
            ]);
        }

        return redirect()->route('categories.index');
    }


    public function editCategory($id)
    {
        $category = Category::with(['subcategories.childCategories'])->findOrFail($id);
        return view('categories.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        // Validate the input
        $validated = $request->validate([
            'Category_name' => 'required',
        ]);
    
        // Handle the category image upload
        if ($request->hasFile('Category_image')) {
            $imageName = 'main_category_images/' . $request->file('Category_image')->getClientOriginalName();
            $request->file('Category_image')->move(public_path('main_category_images'), $request->file('Category_image')->getClientOriginalName());
    
            if ($category->Category_image && file_exists(public_path($category->Category_image))) {
                unlink(public_path($category->Category_image));
            }
            $validated['Category_image'] = $imageName;
        }
    
        // Handle new Subcategories and their child categories
        if ($request->filled('new_subcategories')) {
            foreach ($request->new_subcategories as $subcat) {
                // Check if the subcategory name already exists within the category
                $existingSubcategory = Subcategory::where('category_id', $category->Category_id)
                                                   ->where('name', $subcat['name'])
                                                   ->first();
    
                if ($existingSubcategory) {
                    return redirect()->back()->withErrors(['error' => 'Subcategory name already exists within this category.']);
                }
    
                // Create new subcategory
                $subcategory = Subcategory::create([
                    'category_id' => $category->Category_id,
                    'name' => $subcat['name'],
                ]);
    
                // Check for duplicate child categories within each subcategory
                if (!empty($subcat['childcategories'])) {
                    foreach ($subcat['childcategories'] as $childcat) {
                        // Check if child category name already exists in the same subcategory
                        $existingChildCategory = ChildCategory::where('subcategory_id', $subcategory->id)
                                                              ->where('name', $childcat['name'])
                                                              ->first();
    
                        if ($existingChildCategory) {
                            return redirect()->back()->withErrors(['error' => 'Child category name already exists under this subcategory.']);
                        }
    
                        // Create new child category
                        ChildCategory::create([
                            'category_id' => $category->Category_id,
                            'subcategory_id' => $subcategory->id,
                            'name' => $childcat['name'],
                        ]);
                    }
                }
            }
        }
    
        // Update the category data
        $category->update($validated);
    
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }
    
    



    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        Storage::disk('public')->delete($category->Category_image);
        $category->delete();

        return redirect()->route('categories.index');
    }

    public function getSubcategories($id)
    {
        return response()->json(Subcategory::where('category_id', $id)->get());
    }

    public function getChildcategories($id)
    {
        return response()->json(ChildCategory::where('subcategory_id', $id)->get());
    }

    public function selectDefaultImage($id)
    {
        $mainCategory = Category::findOrFail($id);
        return view('categories.select_default_image', compact('mainCategory'));
    }

    public function storeDefaultImage(Request $request)
    {
        $request->validate(['default_image' => 'required']);

        session(['default_subcategory_image' => $request->default_image]);

        return redirect()->route('categories.createSub', $request->main_category_id);
    }

    public function selectChildDefaultImage($mainCategoryId, $subCategoryId)
    {
        $mainCategory = Category::findOrFail($mainCategoryId);
        $subCategory = Subcategory::findOrFail($subCategoryId);

        return view('categories.select_child_default_image', compact('mainCategory', 'subCategory'));
    }

    public function storeChildDefaultImage(Request $request)
    {
        $request->validate([
            'default_child_image' => 'required',
            'main_category_id' => 'required',
            'sub_category_id' => 'required'
        ]);

        session(['default_childcategory_image' => $request->default_child_image]);

        return redirect()->route('categories.createChild', [
            'categoryId' => $request->main_category_id,
            'subCategoryId' => $request->sub_category_id
        ]);
    }

    public function createMainFromVendor()
    {
        $recentCategories = Category::orderBy('created_at', 'desc')->take(2)->get();
        return view('vendor_details.create_main_from_vendor', compact('recentCategories'));
    }
    public function storeMainCategoryFromVendor(Request $request)
    {
        $validated = $request->validate([
            'Category_name' => 'required',
            'Category_image' => 'required|image|mimes:jpeg,png,jpg|max:150',
        ]);

        $file = $request->file('Category_image');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // This works on cPanel, assuming public_html is root (one level up from app folder)
        $targetDirectory = dirname(__DIR__, 3) . '/main_category_images';

        // Ensure directory exists (skip if you're sure folder already exists)
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Move file directly into `public_html/main_category_images`
        $file->move($targetDirectory, $fileName);

        // Save relative path only (used by asset() or direct links)
        $category = Category::create([
            'Category_name' => $validated['Category_name'],
            'Category_image' => 'main_category_images/' . $fileName,
            'user_id' => auth()->id(),

        ]);

        // Check which button was clicked
        if ($request->has('saveAndCreateSub')) {
            return redirect()->route('categories.createSubFromVendor', ['id' => $category->id]);
        }

        return redirect()->route('vendor_details.create')->with('success', 'Category added successfully!');
    }

    public function createSubCategoryFromVendor($categoryId)
    {
        $mainCategory = Category::findOrFail($categoryId);
        $mainCategory->Category_image = asset($mainCategory->Category_image);

        return view('vendor_details.add_sub_category_vendor', compact('mainCategory'));
    }
    public function storeSubCategoryFromVendor(Request $request)
    {
        foreach ($request->subcategories as $subcategory) {
            Subcategory::create([
                'category_id' => $request->main_category_id,
                'name' => $subcategory['name'],
                'user_id' => auth()->id(),
                'default_image' => str_replace(url('/'), '', $subcategory['image']),
            ]);
        }

        return redirect()->route('categories.createChildFromVendor', [$request->main_category_id, 0]);
    }
    public function createChildCategoryFromVendor($categoryId, $subCategoryId)
    {
        $mainCategory = Category::findOrFail($categoryId);
        $subCategories = Subcategory::where('category_id', $categoryId)->get();

        return view('vendor_details.add_child_category_vendor', compact('mainCategory', 'subCategories'));
    }
    public function storeChildCategoryFromVendor(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'childcategories.*.subcategory_id' => 'required|exists:subcategories,id',
            'childcategories.*.name' => 'required|string|max:255',
        ], [
            'childcategories.*.subcategory_id.required' => 'Subcategory is required.',
            'childcategories.*.name.required' => 'Child category name is required.',
        ]);
        
        // Loop through each child category to check if it already exists
        foreach ($request->childcategories as $index => $childcategory) {
            $existingChildCategory = ChildCategory::where('subcategory_id', $childcategory['subcategory_id'])
                ->where('name', $childcategory['name'])
                ->first();
            
            if ($existingChildCategory) {
                // If duplicate found, return with an error
                return back()->withErrors([
                    "childcategories.$index.name" => "The child category '{$childcategory['name']}' already exists in this subcategory."
                ])->withInput();
            }
            
            // Handle the image upload (if any)
            $imagePath = null;
            if (isset($childcategory['image'])) {
                $imagePath = $childcategory['image']; // Assuming image comes as a path or URL
            } else {
                // If no image was provided, set the default image
                $imagePath = session('default_childcategory_image', '/images/default.png');
            }
    
            // Perform raw SQL query to insert the child category data
            \DB::table('child_categories')->insert([
                'category_id' => $request->main_category_id,
                'subcategory_id' => $childcategory['subcategory_id'],
                'name' => $childcategory['name'],
                'user_id' => auth()->id(),
                'default_image' => $imagePath,  // Use the image path
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('categories.index')->with('success', 'Category and all sub/child categories added!');
    }
    
    
    
    
    
    
}
