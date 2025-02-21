@extends('layouts.master')
@section('title')
    برنامج الفواتير
@endsection
@section('css')
    <!-- Owl-carousel css -->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <style>
        .sales-card {
            transition: transform 0.3s ease-in-out;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .sales-card:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">👋 مرحبًا بك مجددًا!</h2>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-sm">
        @php
            $totalInvoices = App\Models\invoices::count();
            $paidInvoices = App\Models\invoices::where('status_value', 1)->count();
            $unpaidInvoices = App\Models\invoices::where('status_value', 2)->count();
            $partialInvoices = App\Models\invoices::where('status_value', 3)->count();
        @endphp

        @foreach ([['اجمالي الفواتير', 'primary', App\Models\invoices::sum('total'), $totalInvoices, 'fas fa-chart-line'], ['الفواتير غير المدفوعة', 'danger', App\Models\invoices::where('status_value', 2)->sum('total'), $unpaidInvoices, 'fas fa-exclamation-circle'], ['الفواتير المدفوعة', 'success', App\Models\invoices::where('status_value', 1)->sum('total'), $paidInvoices, 'fas fa-check-circle'], ['الفواتير المدفوعة جزئيا', 'warning', App\Models\invoices::where('status_value', 3)->sum('total'), $partialInvoices, 'fas fa-hourglass-half']] as [$title, $color, $amount, $count, $icon])
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-{{ $color }}-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2">
                        <h6 class="mb-3 tx-12 text-white">{{ $title }}</h6>
                        <div class="d-flex">
                            <div>
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format($amount, 2) }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير: {{ $count }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="{{ $icon }} text-white"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <h4 class="card-title mb-0">📊 نسبة احصائية الفواتير</h4>
                </div>
                <div class="card-body" style="width: 70%">
                     {!! $chartjs->render() !!}
=              </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-5">
            <div class="card card-dashboard-map-one">
                <label class="main-content-label">📈 نسبة احصائية الفواتير</label>
                <div class="" style="width: 100%">
              {!! $chartjs_2->render() !!}
              </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
