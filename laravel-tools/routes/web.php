<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Category\CategoryController;
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


Route::prefix('categories')->name('categories.')->group(function () {
 Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');

});