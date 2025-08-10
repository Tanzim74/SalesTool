<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;

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
    return view('welcome');
});

Route::controller(ReportController::class)->group(function () {
    Route::post('/getColumns', [ReportController::class, 'getColumns'])->name('sales.report.get_columnns'); //later make it post
    Route::post('/sales-report', [ReportController::class, 'getSales'])->name('sales.report.index');
    Route::post('/search', [ReportController::class, 'search']);
});





Route::get('/get-sales-summary', [ReportController::class, 'getSalesSummary'])
    ->name('sales.summary');


Route::get('/view-sales', [ReportController::class, 'viewSales'])->name('reports.sales');
