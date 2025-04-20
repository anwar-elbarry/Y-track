<?php
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
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
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout',[AuthController::class,'logOut'])->name('logout');
    });    
});

Route::prefix('/income')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[IncomeController::class,'index']);
        Route::post('/create',[IncomeController::class,'store']);
        Route::put('/update/{id}',[IncomeController::class,'update']);
        Route::post('/removeMultiple',[IncomeController::class,'destroyMultiple']);
        Route::delete('/remove/{id}',[IncomeController::class,'destroy']);
    });
});
Route::prefix('/expense')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[ExpenseController::class,'index']);
        Route::post('/create',[ExpenseController::class,'store']);
        Route::put('/update/{id}',[ExpenseController::class,'update']);
        Route::post('/removeMultiple',[ExpenseController::class,'destroyMultiple']);
        Route::delete('/remove/{id}',[ExpenseController::class,'destroy']);
    });
});