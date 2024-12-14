<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index(){
        $bundles = Bundle::all();
        return view('bundles.index',compact('bundles'));
    }
    public function create(){
        $products = Product::all();
        return view('bundles.create',compact('products'));
    }
    // public function store(Request $request){
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'product_ids' => 'required',
    //         'discount_type' => 'required',
    //         'price' => 'required',
    //     ]);
    //     // $bundle = Bundle::create($request->all());
    //     $products = Product::whereIn('id', $request->product_ids)->get();
        
    //     $totalPrice = $products->sum('new_price');
    //     $discountedPrice = $totalPrice - ($totalPrice * $request->price / 100);
    //     // dd($totalPrice,$discountedPrice,$request->price );

    //     $bundle = Bundle::create($request->only('name', 'discount_type','price','product_ids'));
    //     $bundle->products()->attach($request->product_ids);

    //     return redirect()->route('bundle.index')->with('success', 'Bundle Created successfully!');

    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_ids' => 'required|array',
            'discount_type' => 'required',
            'price' => 'required|numeric',
        ]);
        $products = Product::whereIn('id', $request->product_ids)->get();
        
        // Calculate the discounted price
        $totalPrice = $products->sum('new_price');
        $discountedPrice = ($request->discount_type === 'Percentage')
        ? $totalPrice - ($totalPrice * $request->price / 100)
        : $totalPrice - $request->price;
        
        // dd(json_encode($request->product_ids));
        $bundle = Bundle::create([
            'name' => $request->name,
            'discount_type' => $request->discount_type,
            'price' => $request->price,
            'product_ids' => json_encode($request->product_ids),
        ]);
        $bundle->products()->attach($request->product_ids);

        return redirect()->route('bundle.index')->with('success', 'Bundle Created successfully!');
    }

    public function edit($id)
    {
        // Find the specific bundle to edit
        $bundle = Bundle::findOrFail($id);
    
        // Fetch all products to display in the form
        $products = Product::all();
    
        return view('bundles.edit_bundle', compact('bundle', 'products'));
    }

    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'product_ids' => 'required|array', // Ensure product_ids is an array
            'product_ids.*' => 'exists:products,id', // Validate that each product_id exists
            'discount_type' => 'required',
            'price' => 'required|numeric|min:0', // Discount percentage or fixed value
        ]);
        $products = Product::whereIn('id', $validatedData['product_ids'])->get();
        
        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'No valid products selected for the bundle.');
        }
        
        // Calculate the total price of the selected products
        $totalPrice = $products->sum('new_price');
        
        // Calculate the discounted price based on the discount type
        $discountedPrice = $totalPrice - ($totalPrice * $validatedData['price'] / 100);
        $bundles = Bundle::findOrFail($request->id);
        
        try {

            // $bundles->update([
            //     'name' => $validatedData['name'],
            //     'status' => $validatedData['status'],
            //     'price' => $validatedData['price'], // Store the discounted price
            // ]);

            $bundle = $bundles->update([
                'name' => $validatedData['name'],
                'discount_type' => $validatedData['discount_type'],
                'price' => $validatedData['price'], // Store the discounted price
                'product_ids' => json_encode($request->product_ids),
            ]);
            
            $bundles->products()->sync($validatedData['product_ids']);

            return redirect()->route('bundle.index')->with('success', 'Bundle updated successfully!');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    
}
