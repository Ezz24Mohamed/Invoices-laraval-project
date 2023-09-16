<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Section;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $products = Products::all();
        return view('products.product', compact('sections', 'products'));
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
        $validate = $request->validate(
            [
                'product_name' => 'required|max:255',
                'section_id' => 'required'
            ],
            [
                'product_name.required' => 'يرجي ادخال المنتج',
                'section_id.required' => 'يرجي ادخال القسم',
            ]
        );
        Products::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        /*first()=> return the first row in the section table which matches the query*/
        $sec_id = Section::where('section_name', $request->section_name)->first()->id;
        $pro_id = $request->product_id;
        $validate = $request->validate(
            [
                'product_name' => 'required',
            ]
            ,
            [
                'product_name.required' => 'يرجي ادخال اسم المنتج',
            ]
        );
        $products = Products::findOrFail($pro_id);
        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $sec_id,
        ]);
        session()->flash('update', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pro_id=$request->product_id;
        Products::find($pro_id)->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return back();
    }
}