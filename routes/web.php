<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\UserController;
use App\Http\Controllers\Website\GrossController;
use App\Http\Controllers\Website\LoginController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\StockController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\CustomerController;
use App\Http\Controllers\Website\DashboardController;
use App\Http\Controllers\Website\TransactionController;

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

Route::controller(LoginController::class)
->group(function () {
    Route::get("/","index")->name('login')->middleware('guest');
    Route::post("/","authenticate");
    Route::post("/logout","logout");
});

Route::middleware('auth', 'isAdmin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/orders/session', [OrderController::class, 'sessionControl']);

    Route::resource('/orders', OrderController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/stocks', StockController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/users', UserController::class);

    Route::get('/reports/transactions', [TransactionController::class, 'index']);
    Route::post('/reports/transactions', [TransactionController::class, 'show']);

    Route::get('/reports/grosses', [GrossController::class, 'index']);
    Route::post('/reports/grosses', [GrossController::class, 'show']);

    Route::get('/home', function () {
        return view('web.admin.home.index');
    });
});


Route::middleware('auth','isStaff')->group(function(){

    Route::get('/home',function(){
        return view('web.staff.home.index');
    });

    Route::resource('/orders', OrderController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/users', UserController::class);
   
});

