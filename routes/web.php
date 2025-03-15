<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('front.home');
});

// auth
Route::get('/auth',[AuthController::class,'index'])->name('auth');
Route::post('/auth/signup',[AuthController::class,'signUp'])->name('signup');
Route::post('/auth/signin',[AuthController::class,'signIn'])->name('signin');
Route::post('/auth/logout',[AuthController::class,'logOut'])->name('logout');
