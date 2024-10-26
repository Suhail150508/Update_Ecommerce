<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    use ImageUpload;

    /**
    * Display a listing of the subcategories with pagination.
    */
    public function index()
    {
        $subcategories = Subcategory::orderBy('created_at', 'desc')->paginate(3);
        return view('subcategories.index', compact('subcategories'));
    }

    /**
    * Show the form for creating a new subcategory.
    */
    public function create()
    {
        $categories = Category::all();
        return view('subcategories.create', compact('categories'));
    }

    /**
    * Validates input and stores a new subcategory.
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:subcategories,name', 
            'category_id' => 'required|exists:categories,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        // Upload image if provided
        $imagePath = $request->hasFile('image') ? $this->ImageUpload($request->file('image'), 'upload/image') : null;

        $sub_cat = Subcategory::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['name']),
            'image' => $imagePath,
        ]);

        return redirect()->route('subcategories.index')->with('success', $sub_cat ? 'Subcategories created successfully!' : 'Subcategories not created!');
    }

    /**
    * Shows the form to edit an existing subcategory.
    */
    public function edit($slug)
    {
        $categories = Category::all();
        $subcategories = Subcategory::findOrFail($slug);

        return view('subcategories.edit', compact('categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required', 
            'category_id' => 'required|exists:categories,id', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $subcategory = Subcategory::findOrFail($id);

        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            if ($subcategory->image) {
                $oldImagePath = public_path($subcategory->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Upload new image
            $imagePath = $this->ImageUpload($request->file('image'), 'upload/image');
        }

        $upd_category = $subcategory->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['name']),
            'image' => $imagePath ? $imagePath : $subcategory->image, 
        ]);

        // Redirect with success message
        return redirect()->route('subcategories.index')->with('success', $upd_category ? 'Subcategories updated successfully!' : 'There is an error');
    }

    /**
    * Deletes a subcategory and checks for related products.
    */
    public function destroy(Subcategory $subcategory)
    {
        session()->put('id', $subcategory->id);
        $subcategory_delete = Product::where('subcategory_id', $subcategory->id)->first();

        if ($subcategory_delete) {
            return redirect()->route('subcategories.index')->with('warning', 'Product exists for this subcategory. Are you sure you want to delete it?');
        } else {
            $subcategory->delete();
            session()->delete();
            return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully!');
        }
    }

     /**
    * Confirms deletion of a subcategory.
    */
    public function confirmDelete($id)
    {
        $session_id = session()->get('id');
        if ($id == $session_id) {
            $subcategory_delete = Subcategory::findOrFail($id);
            $subcategory_delete->delete();
            return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully!');
        } else {
            $subcategory_delete = Subcategory::findOrFail($session_id);
            $subcategory_delete->delete();
            session()->delete();
            return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully!');
        }
    }
}
