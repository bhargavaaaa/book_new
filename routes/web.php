<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StandardController;
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
        Route::get('/changeStatus/{id}', [StandardController::class, 'changeStatus'])->name('standard.changeStatus');
    });

    // Route::prefix('category')->group(function () {
    //     Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    //     Route::get('/getData', [CategoryController::class, 'getData'])->name('category.getData');
    //     Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    //     Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    //     Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    //     Route::get('/changeStatus/{id}', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
    // });
});
