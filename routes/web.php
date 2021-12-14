<?php

use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function(){
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('/users/status/{user_id}/{status_code}', [UserController::class, 'updateStatus'])->name('users.status.update');
});

/// facebook Login url

Route::prefix('facebook')->name('facebook.')->group( function(){
    Route::get('auth', [FacebookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [FacebookController::class, 'callbackFromFacebook'])->name('callback');
});

/// google Login url

Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
    Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
});
