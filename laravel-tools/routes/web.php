<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\MedicineController;
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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
