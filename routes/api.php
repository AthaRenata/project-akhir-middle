<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GrossController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransactionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[ApiAuthController::class,'login']);
Route::get('/logout',[ApiAuthController::class,'logout']);

Route::middleware('api-auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/grosses', [GrossController::class, 'show']);
    Route::post('/transactions', [TransactionController::class, 'show']);

    Route::controller(CategoryController::class)
        ->prefix("/categories")
        ->group(function () {
    
            Route::get("/", "index"); 
            Route::get("/{id}", "show"); 
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy"); 
        
        });
        
    Route::controller(CustomerController::class)
        ->prefix("/customers")
        ->group(function () {
    
            Route::get("/", "index"); 
            Route::get("/{id}", "show"); 
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy"); 
        
        });

    Route::controller(OrderController::class)
        ->prefix("/orders")
        ->group(function () {
    
            Route::get("/", "index"); 
            Route::get("/{id}", "show"); 
            Route::post("/", "store");
            Route::delete("/{id}", "destroy"); 
        
        });

    Route::controller(ProductController::class)
        ->prefix("/products")
        ->group(function () {
    
            Route::get("/", "index"); 
            Route::get("/{id}", "show"); 
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy"); 
        
        });

    Route::controller(StockController::class)
        ->prefix("/stocks")
        ->group(function () {
    
            Route::get("/", "index"); 
            Route::get("/{id}", "show"); 
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy"); 
        
        });

    Route::controller(UserController::class)
        ->prefix("/users")
        ->group(function () {
    
            Route::get("/", "index"); 
            Route::get("/{id}", "show"); 
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy"); 
        
        });
});