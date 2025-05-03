<?php
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BillsCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\Upcoming_BillsController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\NotificationController;
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
        Route::get('/user', [AuthController::class,'getUser']);
        Route::put('/changePassword',[AuthController::class,'changePassword']);
        Route::put('/updateUser',[AuthController::class,'updateUser']);
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

Route::prefix('/category')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[CategoryController::class,'index']);
        Route::get('/statistics',[CategoryController::class,'getCategoryWithAmount']);
        Route::post('/create',[CategoryController::class,'store']);
        Route::delete('/remove/{id}',[CategoryController::class,'destroy']);
    });
});

Route::prefix('/bills-category')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[BillsCategoryController::class,'index']);
        Route::post('/create',[BillsCategoryController::class,'store']);
        Route::delete('/remove/{id}',[BillsCategoryController::class,'destroy']);
    });
});

Route::prefix('/client')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[ClientController::class,'index']);
        Route::post('/create',[ClientController::class,'store']);
        Route::put('/update/{id}',[ClientController::class,'update']);
        Route::delete('/remove/{id}',[ClientController::class,'destroy']);
    });
});

Route::prefix('/bill')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[BillController::class,'index']);
        Route::post('/create',[BillController::class,'store']);
        Route::put('/update/{id}',[BillController::class,'update']);
        Route::delete('/remove/{id}',[BillController::class,'destroy']);
        Route::post('/removeMultiple',[BillController::class,'destroyMultiple']);
        Route::post('/{billId}/pay', [BillController::class, 'pay']);
    });
});

Route::prefix('/transaction')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[TransactionController::class,'index']);
        Route::delete('/remove/{id}',[TransactionController::class,'destroy']);
        Route::post('/removeMultiple',[TransactionController::class,'destroyMultiple']);
    });
});


Route::prefix('/goal')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[GoalController::class,'index']);
        Route::post('/create',[GoalController::class,'store']);
        Route::delete('/remove/{id}',[GoalController::class,'destroy']);
        Route::put('/update/{id}',[GoalController::class,'update']);
    });
});

Route::prefix('/upcoming-bill')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[Upcoming_BillsController::class,'index']);
        Route::post('/create',[Upcoming_BillsController::class,'store']);
        Route::delete('/remove/{id}',[Upcoming_BillsController::class,'destroy']);
        Route::put('/update/{id}',[Upcoming_BillsController::class,'update']);
        Route::post('/{upcoming_billId}/pay', [Upcoming_BillsController::class, 'pay']);
    });
});

Route::prefix('/invoice')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[InvoiceController::class,'index']);
        Route::post('/create',[InvoiceController::class,'store']);
        Route::put('/update/{id}',[InvoiceController::class,'update']);
        Route::delete('/remove/{id}',[InvoiceController::class,'destroy']);
        Route::get('/{id}',[InvoiceController::class,'show']);
    });
});

Route::prefix('/statistics')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[StatisticsController::class,'index']);
    });
});

Route::prefix('/notifications')->group(function (){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[NotificationController::class,'index']);
        Route::delete('/remove/{id}',[NotificationController::class,'destroy']);
        Route::put('/markAsRead/{id}',[NotificationController::class,'markAsRead']);
        Route::delete('/clear-all', [NotificationController::class, 'clearAll']);
    });
});