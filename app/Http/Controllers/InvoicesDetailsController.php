<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', '=', $id)->first();
        $details = invoices_details::where('id_invoices', '=', $id)->get();
        $attachments = invoices_attachments::where('id_invoices', '=', $id)->get();
        return view('invoices.invoices_details', compact('invoices', 'details', 'attachments'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoices_attachments::findOrFail($request->file_id);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoices_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();

    }
    public function openFile($invoices_number, $file_name)
    {
        $file = Storage::disk('public_uploads')->path($invoices_number . '/' . $file_name);
        return response()->file($file);


    }
    public function downloadFile($invoices_number, $file_name)
    {
        $file = Storage::disk('public_uploads')->path($invoices_number . '/' . $file_name);
        return response()->download($file);

    }

}
