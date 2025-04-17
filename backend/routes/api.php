<?php
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    // Auth Routes
Route::prefix('/auth')->group(function(){
    Route::get('/',[AuthController::class,'index'])->name('auth');
    Route::post('/signup',[AuthController::class,'signUp'])->name('signup');
    Route::post('/signin',[AuthController::class,'signIn'])->name('signin');
    // googleAuth
    Route::get('/google',[GoogleAuthController::class,'redirect'])->name('google.login');
    Route::get('/google/callback',[GoogleAuthController::class,'callback']);
    // FacebookAuth
    Route::get('/facebook',[FacebookAuthController::class,'redirect'])->name('facebook.login');
    Route::get('/facebook/callback',[FacebookAuthController::class,'callback']);
    // logoutAuth
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/logout',[AuthController::class,'logOut'])->name('logout');
    });    
});
