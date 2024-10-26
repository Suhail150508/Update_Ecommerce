<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Traits\ImageUpload;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function App\Providers\logActivity;

class ProductController extends Controller
{
    use ImageUpload;

    /**
    * Display paginated products with exploded images for easy display.
    */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(5);
        
        foreach ($products as $product) {
            $product->image = $product->image ? explode("|", $product->image) : [];
        }
    
        return view('products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
    * Display all products with pagination and category filters.
    */
    public function showAllProducts()
    {
        $categories = Category::all();
        $products = Product::paginate(6);
        
        foreach ($products as $product) {
            $product->image = $product->image ? explode("|", $product->image) : [];
        }
    
        return view('products.show_product', compact('products', 'categories'));
    }
    
    /**
    * Filter products by category and subcategory with pagination
    */
    public function filterProducts(Request $request)
    {
        $categoryId = $request->input('category_id');
        $subcategoryId = $request->input('subcategory_id');
        $categories = Category::all();

        // Filter by category
        if( $categoryId ){

            session(['selectedCategoryId' => $categoryId]);
            $category = Category::with('products')->find($request->category_id);
            $products = $category->products()->paginate(6);

            foreach ($products as $product) {
                $product->image = $product->image ? explode("|", $product->image) : [];
            }
        
            return view('products.show_product', compact('products','categories'))->render();

        }

        /**
        * Filter by both category and subcategory
        */
        if($categoryId & $subcategoryId ){

            session(['selectedSubcategoryId' => $subcategoryId]);

            $products = Product::where('category_id', $request->category_id)
            ->where('subcategory_id', $request->subcategory_id)
            ->paginate(6);
        
            foreach ($products as $product) {
                $product->image = $product->image ? explode("|", $product->image) : [];
            }
        
            return view('products.show_product', compact('products','categories'))->render();
        }

        $products = Product::paginate(6);
        
        foreach ($products as $product) {
            $product->image = $product->image ? explode("|", $product->image) : [];
        }
    
        return view('products.show_product', compact('products','categories'))->render();
    }
    
    /**
    * Show product by slug
    */
    public function show($slug){
        $product = Product::where('slug',$slug)->first();
        if ($product) {
            $product->image = $product->image ? explode("|", $product->image) : [];
        }
        return view('products.product_details',compact('product'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required|exists:subcategories,id',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'images.*' => 'nullable|image|max:2048'
        ]);

        // Initialize the product model
        $product = new Product;
        $product->name= $request->name;
        $product->slug= Str::slug($request->name);
        $product->description= strip_tags($request->description);
        $product->old_price= $request->old_price;
        $product->new_price= $request->new_price;
        $product->category_id= $request->category_id;
        $product->subcategory_id= $request->subcategory_id;

        $images=array();

         // Handle image uploads and processing
        if($files=$request->file('file')){
            $i=0;
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $fileNameExtract=explode('.',$name);
                $fileName=$fileNameExtract[0];
                $fileName.=time();
                $fileName.=$i;
                $fileName.='.';
                $fileName.=$fileNameExtract[1];
                // Move the file to the desired folder (image/)
                $file->move('image',$fileName);
                $images[]=$fileName;
                $i++;
            }
            $product['image'] = implode("|",$images);
            
        }
        $product->save();

        logActivity('Created a product', $product, ['attributes' => $product->toArray()]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');

        // Redirect with a success message after saving
        return redirect()->route('products.index')->with('success', 'Product does not created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('products.edit', compact('product', 'subcategories','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required|exists:subcategories,id',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'images.*' => 'nullable|image|max:2048'
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = strip_tags($request->description); // strip HTML tags
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;

        $existingImages = explode('|', $product->image); // Get existing images
        $images = [];

        if ($files = $request->file('file')) {
            $i = 0;
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $fileNameExtract = explode('.', $name);
                $fileName = $fileNameExtract[0] . time() . $i . '.' . $fileNameExtract[1];

                $file->move('image', $fileName);
                $images[] = $fileName;
                $i++;
            }
            // Append new images to existing ones
            $product->image = implode('|', array_merge($existingImages, $images));
        }
        $product->save();

        logActivity('Updated a product', $product, ['attributes' => $product->toArray()]);


        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    public function removeImage($id, $image)
    {
        $product = Product::findOrFail($id);
        $images = explode('|', $product->image);

        if (($key = array_search($image, $images)) !== false) {
            unset($images[$key]);
        }


        $product->image = implode('|', $images);
        $product->save();

        return response()->json(['message' => 'Image removed successfully.'], 200); 
    }

    
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    /**
    * Deletion of the product.
    */
    public function destroy($id)
    {
        // Start the transaction
        DB::beginTransaction();

        try {
            // Attempt to find and delete the product
            $product = Product::findOrFail($id);

            // Delete the product
            $product->delete();

            // If everything is fine, commit the transaction
            DB::commit();

            logActivity('Deleted a product', $product, ['attributes' => $product->toArray()]);

            // Redirect with success message
            return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            // If something goes wrong, rollback the transaction
            DB::rollBack();

            // You can log the error or return an error message
            return redirect()->route('products.index')->with('error', 'Failed to delete the product.');
        }
    }

}
