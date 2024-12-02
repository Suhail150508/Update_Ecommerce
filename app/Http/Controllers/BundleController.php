<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index(){
        return view('bundles.index');
    }
    public function create(){
        return view('bundles.create');
    }
    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'discount' => 'required',
        ]);
        // $bundle = Bundle::create($request->all());
        $bundle = Bundle::create($request->only('name', 'discount'));
        // $bundle->products()->attach($request->products);
        // dd('ok',$bundle );

        return redirect()->to('bundles');

    }
}
