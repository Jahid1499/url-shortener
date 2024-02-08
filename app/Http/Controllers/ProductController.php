<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::paginate(10);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name'=>'required',
           'price'=>'required'
        ]);
        Products::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price')
        ]);
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required'
        ]);
        Products::findOrFail($id)->update([
            'name'=>$request->input('name'),
            'price'=>$request->input('price')
        ]);
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        Products::findOrFail($id)->delete();
        return redirect()->route('product.index');
    }


}
