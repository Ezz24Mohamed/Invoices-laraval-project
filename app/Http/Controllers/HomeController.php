<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoices = invoices::count();
        $paidInvoices = (invoices::where('status_value', 1)->count() / $invoices) * 100;
        $unPaidInvoices = (invoices::where('status_value', 2)->count() / $invoices) * 100;
        $partialInvoices = (invoices::where('status_value', 3)->count() / $invoices) * 100;
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$unPaidInvoices]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$paidInvoices]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$partialInvoices]
                ],


            ])
            ->options([]);
        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$paidInvoices, $unPaidInvoices, $partialInvoices]
                ]
            ])
            ->options([]);

       return view('home', compact('chartjs', 'chartjs_2')); 


return view('home',);
}
}
