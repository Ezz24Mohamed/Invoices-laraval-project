<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\invoices;

class ClientsReports extends Controller
{
    public function index()
    {
        $sections = sections::all();
        return view('reports.clients_reports', compact('sections'));
    }
    public function search(Request $request)
    {

        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $sections = sections::all();
            $invoices = invoices::where('section_id', $request->Section)->where('product', $request->product)->get();
            return view('reports.clients_reports', compact('sections'))->withDetails($invoices);
        }
        else{
            $start_at=date($request->start_at);
            $end_at=date($request->end_at);
            $invoices=invoices::whereBetween('invoices_date',[$start_at,$end_at])->where('section_id',$request->Section)->where('product',$request->product)->get();
            $sections=sections::all();
            return view('reports.clients_reports',compact('sections'))->withDetails($invoices);
        }
    }
}
