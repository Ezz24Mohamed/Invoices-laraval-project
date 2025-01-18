<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();

        return view('products.products', compact('sections', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'product_name' => 'unique:products|max:255|required',
                'section_id' => 'required',

            ],
            [
                'product_name.unique' => 'هذا المنتج موجود بالفعل',
                'product_name.required' => 'يرجي ادخال اسم المنتج',
                'section_id.required' => 'يرجي ادخال اسم القسم',
            ]
        );

        products::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
            'created_by' => Auth::user()->name,
        ]);
        session()->flash('Add', 'تم الاضافة بنجاح');
        return redirect('/products');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $section_id = sections::where('section_name', '=', $request->section_name)->first()->id;
        $products = products::findOrFail($request->pro_id);
        $this->validate(
            $request,
            [
                'product_name' => 'required',
            ],
            [
                'product_name.required' => 'يرجي ادخال اسم المنتج',
            ]
        );

        $products->update([
            'product_name' => $request->product_name,
            'section_id' => $section_id,
            'description' => $request->description,
        ]);
        session()->flash('edit', 'تم التعديل بنجاح');
        return redirect('/products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = products::findOrFail($request->pro_id);
        $product->delete();
        session()->flash('delete', 'تم الحذف بنجاح');
        return redirect('/products');
    }
}
