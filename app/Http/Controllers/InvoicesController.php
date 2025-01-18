<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\sections;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add', compact('sections'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices ::create([
            'invoices_number'=>$request->invoice_number,
            'invoices_date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'section_id'=>$request->Section,
            'product'=>$request->product,
            'amount_collection'=>$request->Amount_collection,
            'amount_comission'=>$request->Amount_Commission,
            'discount'=>$request->Discount,
            'rate_vate'=>$request->Rate_VAT,
            'value_vat'=>$request->Value_VAT,
            'status'=>'غير  مدفوعة',
            'status_value'=>2,
            'note'=>$request->note,
            'total'=>$request->Total,
        ]);
        $invoices_id=invoices::latest()->first()->id;
        invoices_details::create([
            'id_invoices'=>$invoices_id,
            'invoices_number'=>$request->invoice_number,
            'product'=>$request->product,
            'section'=>$request->Section,
            'status'=>'غير مدفوعة',
            'status_value'=>2,
            'user'=>Auth::user()->name,
            'note'=>$request->note,
            'payment_date'=>$request->payment_date,

        ]);
        if($request->hasFile('pic')){
            $invoices_id=invoices::latest()->first()->id;
            $image=$request->file('pic');
            $file_name=$image->getClientOriginalName();
            $invoices_number=$request->invoice_number;

            $attachments=new invoices_attachments();
            $attachments->id_invoices=$invoices_id;
            $attachments->file_name=$file_name;
            $attachments->user=Auth::user()->name;
            $attachments->invoices_number=$invoices_number;
            $attachments->save();
            $image_name=$request->file('pic')->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'.$invoices_number),$image_name);


        }
        session()->flash('Add','تم اضافة الفاتورة بنجاح');
        return back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices $invoices)
    {
        //
    }
    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', '=', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }






}
