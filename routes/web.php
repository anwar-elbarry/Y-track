<?php

use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;
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
    return view('pages.home');
})->name('home');
Route::get('/aside',function(){
    return view('components.aside');
});
// auth
Route::get('/auth',[AuthController::class,'index'])->name('auth');
Route::post('/auth/signup',[AuthController::class,'signUp'])->name('signup');
Route::post('/auth/signin',[AuthController::class,'signIn'])->name('signin');
Route::post('/auth/logout',[AuthController::class,'logOut'])->name('logout');
// googleAuth
Route::get('/auth/google',[GoogleAuthController::class,'redirect'])->name('google.login');
Route::get('/auth/google/callback',[GoogleAuthController::class,'callback']);
// FacebookAuth
Route::get('/auth/facebook',[FacebookAuthController::class,'redirect'])->name('facebook.login');
Route::get('/auth/facebook/callback',[FacebookAuthController::class,'callback']);