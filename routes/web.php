<?php

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

    /** Bill make */
    Route::get('make-bill', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice.index');
});
