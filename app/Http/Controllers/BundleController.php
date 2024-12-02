<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index(){
        return view('bundles.index');
    }
    public function create(){
        $products = Product::all();
        return view('bundles.create',compact('products'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'product_ids' => 'required',
            'discount_type' => 'required',
            'price' => 'required',
        ]);
        // $bundle = Bundle::create($request->all());
        $products = Product::whereIn('id', $request->product_ids)->get();
        
        $totalPrice = $products->sum('new_price');
        $discountedPrice = $totalPrice - ($totalPrice * $request->price / 100);
        // dd($totalPrice,$discountedPrice,$request->price );

        $bundle = Bundle::create($request->only('name', 'discount_type','price'));
        // $bundle->products()->attach($request->products);

        return redirect()->to('bundles');

    }
}
