<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File; 

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.list', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'description' => 'required|max:2550',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=3000,max_height=3000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // Unique Image Name

            // Saving Image in directory
            $image->move(public_path('uploads/products'), $imageName);

            // Saving Image Name in database
            $product->image = $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:5',
            'description' => 'required|max:2550',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024|dimensions:max_width=3000,max_height=3000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $id)->withInput()->withErrors($validator);
        }

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            // delete old image
            if ($product->image) {
                File::delete(public_path('uploads/products/'.$product->image));
            }

            // here we will store image
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // Unique image name

            // Save image to products directory
            $image->move(public_path('uploads/products'), $imageName);

            // Save image name in database
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // delete image
        if ($product->image) {
            File::delete(public_path('uploads/products/'.$product->image));
        }

        // delete product from database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
