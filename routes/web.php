<?php

use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductController;
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
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductController::class);



Route::get('/{page}', [\App\Http\Controllers\AdminController::class, 'index']);

