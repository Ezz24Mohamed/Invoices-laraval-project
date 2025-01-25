<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\sections;
use Illuminate\Support\Facades\Storage;

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
        invoices::create([
            'invoices_number' => $request->invoice_number,
            'invoices_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'section_id' => $request->Section,
            'product' => $request->product,
            'amount_collection' => $request->Amount_collection,
            'amount_comission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vate' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'status' => 'غير  مدفوعة',
            'status_value' => 2,
            'note' => $request->note,
            'total' => $request->Total,
        ]);
        $invoices_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_invoices' => $invoices_id,
            'invoices_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'status' => 'غير مدفوعة',
            'status_value' => 2,
            'user' => Auth::user()->name,
            'note' => $request->note,
            'payment_date' => $request->payment_date,

        ]);
        if ($request->hasFile('pic')) {
            $invoices_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoices_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->id_invoices = $invoices_id;
            $attachments->file_name = $file_name;
            $attachments->user = Auth::user()->name;
            $attachments->invoices_number = $invoices_number;
            $attachments->save();
            $image_name = $request->file('pic')->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoices_number), $image_name);


        }
        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id', '=', $id)->first();
        return view('invoices.status_update', compact('invoices'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', '=', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoices', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoices_id);
        $this->validate(
            $request,
            [
                'Section' => 'required',
                'Rate_VAT' => 'required',
            ],
            [
                'Section.required' => 'برجاء اختيار اسم القسم',
                'Rate_VAT.required' => 'برجاء اختيار نسبة قيمة الضريبة المضافة',
            ],

        );


        $invoices->update([
            'invoices_number' => $request->invoice_number,
            'invoices_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'section_id' => $request->Section,
            'product' => $request->product,
            'amount_collection' => $request->Amount_collection,
            'amount_comission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vate' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'note' => $request->note,

        ]);
        $attachments = invoices_attachments::where('id_invoices', '=', $request->invoices_id)->get();
        foreach ($attachments as $at) {
            $oldInNumber = $at->invoices_number;
            $newInNumber = $request->invoice_number;
            Storage::disk('public_uploads')->move($oldInNumber . '/' . $at->file_name, $newInNumber . '/' . $at->file_name);
            if (Storage::disk('public_uploads')->exists($oldInNumber)) {
                Storage::disk('public_uploads')->deleteDirectory($oldInNumber);
            }
            $at->update([
                'invoices_number' => $request->invoice_number,
            ]);
        }

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $invoice_id = $request->invoices_id;
        $invoices = invoices::where('id', '=', $invoice_id)->first();
        $atttachments = invoices_attachments::where('id_invoices', '=', $invoice_id)->get();
        foreach ($atttachments as $at) {
            if (Storage::disk('public_uploads')->exists($at->invoices_number)) {
                Storage::disk('public_uploads')->deleteDirectory($at->invoices_number);
            }
        }
        $invoices->forceDelete();
        session()->flash('delete');
        return back();

    }
    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', '=', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }
    public function updateStatus($id, Request $request)
    {
        $invoice_id = $id;
        $invoices = invoices::where('id', '=', $invoice_id)->first();
        $this->validate(
            $request,
            [
                'Status' => 'required',
                'Payment_Date' => 'required',
            ],
            [
                'Status.required' => 'برجاء تحديد حالة الدفع',
                'Payment_Date.required' => 'برجاء ادخال تاريخ الدفع',
            ],
        );
        if ($request->Status == 'مدفوعة') {
            $invoices->update([
                'status_value' => 1,
                'status' => $request->Status,
                'payment_date' => $request->Payment_Date,
            ]);

            invoices_details::create([
                'id_invoices' => $invoice_id,
                'invoices_number' => $invoices->invoices_number,
                'product' => $invoices->product,
                'section' => $invoices->Section,
                'status' => $invoices->status,
                'status_value' => $invoices->status_value,
                'user' => Auth::user()->name,
                'note' => $invoices->note,
                'payment_date' => $invoices->payment_date,

            ]);


        } else {
            $invoices->update([
                'status_value' => 3,
                'status' => $request->Status,
                'payment_date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_invoices' => $invoice_id,
                'invoices_number' => $invoices->invoices_number,
                'product' => $invoices->product,
                'section' => $invoices->Section,
                'status' => $invoices->status,
                'status_value' => $invoices->status_value,
                'user' => Auth::user()->name,
                'note' => $invoices->note,
                'payment_date' => $invoices->payment_date,

            ]);


        }
        session()->flash('edit_status');
        return back();



    }
    public function paidInvoices()
    {
        $invoices = invoices::where('status_value', '=', 1)->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }
    public function unPaidInvoices()
    {
        $invoices = invoices::where('status_value', '=', 2)->get();
        return view('invoices.unpaid_invoices', compact('invoices'));
    }
    public function parialPaid(){
        $invoices=invoices::where('status_value','=',3)->get();
        return view('invoices.partial_invoices',compact('invoices'));
    }






}
