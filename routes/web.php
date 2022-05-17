<?php

use App\Http\Controllers\BookControoler;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\StudentController;
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
    return redirect()->route('home');
});

Auth::routes();

Route::group(["middleware" => "auth"], function() {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /** Profile routes */
    Route::get('profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('profile', [App\Http\Controllers\HomeController::class, 'profileUpdate'])->name('profile.update');
    Route::post('profile/password', [App\Http\Controllers\HomeController::class, 'passwordUpdate'])->name('userpassword.change');

    Route::prefix('standard')->group(function () {
        Route::get('/', [StandardController::class, 'index'])->name('standard.index');
        Route::get('/getData', [StandardController::class, 'getData'])->name('standard.getData');
        Route::get('/create', [StandardController::class, 'create'])->name('standard.create');
        Route::post('/store', [StandardController::class, 'store'])->name('standard.store');
        Route::get('/delete/{id}', [StandardController::class, 'delete'])->name('standard.delete');
        Route::get('/edit/{id}', [StandardController::class, 'edit'])->name('standard.edit');
        Route::post('/update/{id}', [StandardController::class, 'update'])->name('standard.update');
        // Route::get('/changeStatus/{id}', [StandardController::class, 'changeStatus'])->name('standard.changeStatus');
    });

    // Route::prefix('category')->group(function () {
    //     Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    //     Route::get('/getData', [CategoryController::class, 'getData'])->name('category.getData');
    //     Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    //     Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    //     Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    //     Route::get('/changeStatus/{id}', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
    // });

    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/getData', [StudentController::class, 'getData'])->name('student.getData');
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/store', [StudentController::class, 'store'])->name('student.store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('/update/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::get('/delete/{id}', [StudentController::class, 'delete'])->name('student.delete');
        Route::post('/import' ,[StudentController::class, 'import'])->name('student.import');
        Route::get('/export' ,[StudentController::class, 'export'])->name('student.export');
        // Route::get('/changeStatus/{id}', [StudentController::class, 'changeStatus'])->name('student.changeStatus');
    });

    Route::prefix('book')->group(function () {
        Route::get('/', [BookControoler::class, 'index'])->name('book.index');
        Route::get('/getData', [BookControoler::class, 'getData'])->name('book.getData');
        Route::get('/create', [BookControoler::class, 'create'])->name('book.create');
        Route::post('/store', [BookControoler::class, 'store'])->name('book.store');
        Route::get('/edit/{id}', [BookControoler::class, 'edit'])->name('book.edit');
        Route::post('/update/{id}', [BookControoler::class, 'update'])->name('book.update');
        Route::get('/delete/{id}', [BookControoler::class, 'delete'])->name('book.delete');
    });
});
