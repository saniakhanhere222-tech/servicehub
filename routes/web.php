<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController; //gogle route k lye controller ko import kia 

Route::get('/', function () {
    return view('welcome');
});

//auth module 
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']) ->name('register.store');

//for testing only well remove it later dashboard.blade.php is also temporary 
// Route::get('/dashboard', function () {
//     return view('dashboard');
// }); //our temp route been replaced by role based routes

Route::middleware('auth')->group(function () {

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard')
        ->middleware('role:customer');


    Route::get('/provider/dashboard', function () {
        return view('provider.dashboard');
    })->name('provider.dashboard')
        ->middleware('role:provider');


    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')
        ->middleware('role:admin');

});


//login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.store');
//logout route ... logout logic is inside logincontroller 
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

//google auth routes 
  //google k page py redirect 
Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.redirect');
  //google k page k bad kis page py redirect hna hae 
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');

    // Route::post('/auth/google/create-account', [GoogleController::class, 'createAccount'])
    // ->name('google.create-account');
