<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VideoController;
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

Route::prefix('dashboards')->middleware('auth')->group(function () {

    //Admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('dashboards.admin')
        ->middleware('role:admin'); // optional role check

    //Teacher dashboard
    Route::get('/teacher', [TeacherController::class, 'index'])
        ->name('dashboards.teacher')
        ->middleware('role:teacher');

    // Student dashboard
    Route::get('/student', [StudentController::class, 'index'])
        ->name('dashboards.student')
        ->middleware('role:student');
});

Route::get('/test-jitsi', function () {
    return view('test_jitsi');
});

Route::get('/classroom', [VideoController::class, 'index'])->name('classroom');

// Route::controller(ReportController::class)->group(function () {
//     Route::post('/getColumns', [ReportController::class, 'getColumns'])->name('sales.report.get_columnns'); //later make it post
//     Route::post('/sales-report', [ReportController::class, 'getSales'])->name('sales.report.index');
//     Route::post('/search', [ReportController::class, 'search']);
// });

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/create', [AdminController::class, 'create'])->name('dashboards.admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('dashboards.admin.store');

    Route::get('/admin/{id}', [AdminController::class, 'show'])->name('dashboards.admin.show');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('dashboards.admin.edit');
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('dashboards.admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('dashboards.admin.destroy');
});



Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
