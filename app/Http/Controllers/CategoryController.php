<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Traits\ImageUpload;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ImageUpload;

    /**
    * Display a listing of the categories.
    */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(3);
        return view('categories.index', compact('categories'));
    }

    /**
    * Show the form for creating a new category.
    */
    public function create()
    {
        return view('categories.create');
    }

    /**
    * Store a newly created category in the database.
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Handle image upload if image is provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->ImageUpload($request->file('image'), 'upload/image');
        }

        // Create category with validated data
        $cat = Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'image' => $imagePath,
        ]);

        if ($cat) {
            return redirect()->route('categories.index')->with('success', 'Category created successfully!');
        } else {
            return redirect()->route('categories.index')->with('success', 'There is an error');
        }
    }

    /**
    * Show the form for editing the specified category.
    */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
    * Update the specified category in the database.
    */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id); 

        // Handle image replacement if a new image is uploaded
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $oldImagePath = public_path($category->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imagePath = $this->ImageUpload($request->file('image'), 'upload/image');
        }

        $upd_category = $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'image' => $imagePath ? $imagePath : $category->image,
        ]);

        if ($upd_category) {
            return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
        } else {
            return redirect()->route('categories.index')->with('success', 'There is an error!');
        }
    }

    /**
    * Remove the specified category from the database.
    */
    public function destroy(Category $category)
    {
        session()->put('id', $category->id);
        $category_delete = Product::where('category_id', $category->id)->first();
        
        if ($category_delete) {
            return redirect()->route('categories.index')->with('warning', 'Product already created by this category. Are you sure you want to delete it? Deleting this category will also affect its related products.');
        } else {
            $category->delete();
            session()->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
        }
    }

    /**
    * Confirm deletion of the category.
    */
    public function confirmDelete($id)
    {
        $session_id = session()->get('id');
        if ($id == $session_id) {
        } else {
            $category_delete = Category::where('id', $session_id)->first();
            $category_delete->delete();
    
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
        }
    }
}
