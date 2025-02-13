<?php

use App\Http\Controllers\ArchivedInvoicesController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesReports;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login ');
});

Auth::routes(options: ['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices', InvoicesController::class);
Route::get('/section/{id}', action: [InvoicesController::class, 'getProducts']);
Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('view_file/{invoices_number}/{file_name}', [InvoicesDetailsController::class, 'openFile']);
Route::get('download/{invoices_number}/{file_name}', [InvoicesDetailsController::class, 'downloadFile']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');
Route::resource('InvoicesAttachments', InvoicesAttachmentsController::class);
Route::get('edit_invoices/{invoices_id}', [InvoicesController::class, 'edit']);
Route::post('/update_status/{id}', [InvoicesController::class, 'updateStatus'])->name('update_status');
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductController::class);
Route::get('paid_invoices', [InvoicesController::class, 'paidInvoices']);
Route::get('unpaid_invoices', [InvoicesController::class, 'unPaidInvoices']);
Route::get('partial_invoices', [InvoicesController::class, 'parialPaid']);
Route::resource('archived_invoices', ArchivedInvoicesController::class);
Route::get('print_invoices/{id}', [InvoicesController::class, 'printInvoices'])->name('print_invoices');
Route::get('export_invoices', [InvoicesController::class, 'exportInvoices']);
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
Route::get('invoices_reports', [InvoicesReports::class, 'index']);
Route::post('search_invoices', [InvoicesReports::class, 'search']);
Route::get('/{page}', action: [\App\Http\Controllers\AdminController::class, 'index']);

