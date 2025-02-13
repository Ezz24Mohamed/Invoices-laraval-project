<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoicesReports extends Controller
{
    public function index()
    {
        return view('reports.invoices_reports');
    }
    public function search(Request $request)
    {
        $radio = $request->rdio;

        if ($radio == "1") {
            if ($request->type != "كل الفواتير" && $request->start_at == '' && $request->end_at == '') {
                $invoices = invoices::where('status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_reports', compact('type'))->withDetails($invoices);


            } else if ($request->type == "كل الفواتير") {
                $invoices = invoices::all();
                $type = $request->type;
                return view('reports.invoices_reports', compact('type'))->withDetails($invoices);

            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = invoices::whereBetween('invoices_date', [$start_at, $end_at])->where('status', $request->type)->get();
                return view('reports.invoices_reports', compact('type', 'start_at', 'end_at'))->withDetails($invoices);

            }
        } else {
            $invoices = invoices::where('invoices_number', $request->invoice_number)->get();
            return view('reports.invoices_reports')->withDetails($invoices);
        }
    }
}